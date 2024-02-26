<?php

namespace App\Services;

use App\Exceptions\WrongPasscodeException;
use App\Interfaces\ShortenedUrlRepositoryInterface;
use App\Models\ShortenedUrl;
use App\Models\ShortenedUrlsArchive;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ShortenedUrlService
{
    public function __construct(ShortenedUrlRepositoryInterface $shortenedUrlRepository)
    {
        $this->shortenedUrlRepository = $shortenedUrlRepository;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data): array
    {
        // Auto generate short url if not provided
        if (!($data[ShortenedUrl::COL_SHORT_URL] ?? null)) {
            $data[ShortenedUrl::COL_SHORT_URL] = $this->generateShortUrl();
        }

        // Auto generate valid until if not provided
        if (!($data[ShortenedUrl::COL_VALID_UNTIL] ?? null)) {
            $data[ShortenedUrl::COL_VALID_UNTIL] = now()->addHours(24); // TODO extract default value to settings, either DB or .env
//            $data[ShortenedUrl::COL_VALID_UNTIL] = now()->addSeconds(10);
        }

        // Auto generate passcode if not provided
        $passCode = $data[ShortenedUrl::COL_PASSCODE] ?? null;
        if (!$passCode) {
            $passCode = Str::password(ShortenedUrl::LENGTH_PASSCODE, true, true, false); // NOTE. Length is by DB VARCHAR(12)
        }
        $data[ShortenedUrl::COL_PASSCODE] = Hash::make($passCode);

        $data[ShortenedUrl::COL_CREATED_AT] = now();

        $item = $this->shortenedUrlRepository->create($data);

        return [
            $item,
            $passCode,
        ];
    }

    /**
     * @param int $id
     * @param string $passcode
     * @return void
     * @throws WrongPasscodeException
     */
    public function archive(int $id, string $passcode): void
    {
        /** @var ShortenedUrl $item */
        $item = $this->shortenedUrlRepository->getById($id);

        if (!Hash::check($passcode, $item->passcode)) {
            throw new WrongPasscodeException();
        }

        $this->generateArchiveCopy($item);

        // Delete original item to free up the table
        $item->delete();
    }

    /**
     * @param ShortenedUrl $item
     * @param bool $isManuallyDeleted
     * @return void
     */
    public function generateArchiveCopy(ShortenedUrl $item, bool $isManuallyDeleted = true): void
    {
        $archiveItem = new ShortenedUrlsArchive($item->only([
            ShortenedUrl::COL_URL,
            ShortenedUrl::COL_SHORT_URL,
            ShortenedUrl::COL_VALID_UNTIL,
            ShortenedUrl::COL_CREATED_AT,
        ]));

        $archiveItem->{ShortenedUrlsArchive::COL_IS_MANUALLY_DELETED} = $isManuallyDeleted;
        $archiveItem->{ShortenedUrlsArchive::COL_DELETED_AT} = now();
        $archiveItem->save();
    }

    /**
     * @param string $path
     * @return ShortenedUrl|null
     */
    public function getByPath(string $path):? ShortenedUrl
    {
        return $this->shortenedUrlRepository->getByPath($path);
    }

    /**
     * @return string
     */
    private function generateShortUrl(): string
    {
        // TODO implement short url generation
        // TODO check if generated short url is unique

        return Str::lower(Str::random(ShortenedUrl::LENGTH_SHORT_URL));
    }
}

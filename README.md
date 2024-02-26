# URL Shortener Service (Demo)
A simple URL shortener service with API and browser endpoints

## Requirements
- PHP 8.1
- Composer
- Mysql 8.0

## Description
A service with such features:
1. URL shortener takes long url and creates a short url that is easy to remember and share 
2. Upon entering short url, the user is redirected to long url
3. Short URL expires after some time (user can specify) by default 24 hours
4. User can specify a custom short url too 
5. User can delete their short url before it expires
6. Made as a API only except any web url is treated as short url request 
7. No user authentication required (For demo purposes to demonstrate functionality)
8. Expired or removed urls are being archived and stored to a separate database table for future statistics for example 

## API Endpoints
All requests needs to have these headers:

Headers:
- Content-Type: application/json
- Accept: application/json
- X-Requested-With: XMLHttpRequest

### POST /api/shortened-urls
Creates a short url from long url

#### Request
- "url" -> mandatory, long url to be shortened
- "short_url" -> optional, custom short url
- "valid_until" -> optional, date when short url expires
- "passcode" -> optional, passcode to delete short url

```json
{
    "url": "https:\/\/google.lt",
    "short_url": "ahahah",
    "valid_until": "2025-01-01 00:00:00",
    "passcode": "a2c456789"
}
```
#### Response
- "id" -> url id (Needed to view/delete url)
- "url" -> long url to be shortened
- "short_url" -> custom short url
- "valid_until" -> date when short url expires
- "passcode" -> passcode to delete short url (Needed to delete url)
- "created_at" -> auto generated, date when short url was created

```json
{
    "id": 1,
    "url": "https:\/\/google.lt",
    "short_url": "ahahah",
    "passcode": "a2c456789",
    "valid_until": "2025-01-01 00:00:00.000000Z",
    "created_at": "2024-02-26T15:35:15.000000Z"
}
```

### GET /api/shortened-urls/{short_url_id}
Gets all the same data of a short url record except the passcode for security reasons.
Keep in mind it's available until the short url expires

#### Response
```json
{
    "id": 1,
    "url": "https:\/\/google.lt",
    "short_url": "ahahah",
    "valid_until": "2025-01-01 00:00:00.000000Z",
    "created_at": "2024-02-26T15:35:15.000000Z"
}
```

### DELETE /api/shortened-urls/{short_url_id}
Deletes a short url record by id and passcode

#### Request
- "passcode" -> mandatory, passcode to delete short url

```json
{
    "passcode": "a2c456789"
}
```
#### Response
- On success -> Http status 204 (No content)
- On passcode fail -> Http status 403 (Forbidden)
- On record not found -> Http status 422 (Unprocessable Entity)

## Public Endpoints (No headers required, simply through browser)
### GET /{short_url}
On successful short url recognition, user is redirected to long url otherwise 404 page is shown

## Installation
1. Clone the repository
2. Run `composer install`
3. Run `cp .env.example .env`
4. Run `php artisan key:generate`
5. Create a database and set it up in .env file
6. Run `php artisan migrate`
7. Run `php artisan serve` (For API and Browser endpoints)
8. Run `php artisan schedule:work` (For short url expiration check every minute (app/Console/Commands/HandleOldShortenedUrls.php))

## Testing
1. Install/open Postman or other API endpoints testing tool
2. Write all the requests as described in API Endpoints section
3. Run the requests and check the responses (should be in sequence but if you want to test 404 you are free to do so)
4. Open browser and try to access short url (if you have created one and it's still valid)

## Project future developments and ideas
- Analize clients if short url of random letters and numbers is enough to be easily remembered or it should have some other structure like: car number plates (3 letters-3 numbers), or it can be more meaningful like english words or even language selection of most popular words that people remember worldwide, all depends if this project will be used for certain country/product/region or worldwide. Also a meaningful short url can be generated from the long url if we would know that there will be some pattern that we want to follow and/or given long urls follow some pattern.
- Add user authentication (Bearer token or other)
- Maybe limit short url creation or even max valid time per user
- Maybe higher limits could be bought by the user
- Add statistics for short url usage
- Add more security measures
- Cover all endpoints with tests
- Analize and improve performance (Test needed with many short urls to see if index is enough to handle huge numbers of records, maybe HASHED index should be used or other solutions)
- Analize clients if it's enough of 6 characters for short url or it should be more
- Analize clients if it's enough of 24 hours for short url expiration or it should be more
- Analize clients if it's enough of 6 characters for passcode or it should be more
- Analize the usage of the service and improve it accordingly
- Maybe create a frontend for the service if it will be used as a public service
- Hardcoded numbers could be moved to .env file or even to database if it's needed to be changed by the client
- Expired short urls could be handled in a different way, then currently searching for expired ones every minute, this is a potential resources waste, maybe it could be made that only specific time periods could be given to expire, for example only 15min like 00:00, 00:15, 00:30, 00:45, and then a cron job could be set to delete all expired short urls at 00:00, 00:15, 00:30, 00:45, this way we would save resources and still have the same functionality, also there might be many other ways but we're shot of time writing all of them here.

## Caution
- This project is a demo and should not be used in production as it lacks security measures and performance improvements
- Current version -> 1.0.0 so it can have bugs and issues, please contact me if you find any or have any suggestions
- This project is not a final version and can be improved in many ways
- Readme file was written without testing, so it can have some mistakes, please contact me if you find any or have any suggestions




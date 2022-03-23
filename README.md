# Dblog, a simple blog website

## FrontEnd:


### Blog Post Listing page
The page includes 3-4 blog posts

Individual blog post Item consists with:

-   Blog post title

-   Blog post short description/body (Limit to 75 characters)

-   See full post with Hyperlink to the full post

-   Created date

-   If there is an amendment to the post, it shows as the edited date

-    Number of comments for the blog post

### Blog Post View page (Individual Post)
The page shows only one blog post

Page includes

-   Blog page title

-   Blog post Body

-   created date

-   If there is an amendment to the post, it shows as the edited date

-   All available comments and comments show with: Commented person’s name or anonymous, comment message (message limits to 50 characters), created date


-   Area for adding a new comment: Name, comment (limits to 50 characters), save button to save the comment

## Admin / Backend

The backend or Admin consists of following

-   Login to the admin with username and password

-   Ability to add, remove, update other admin users

-   Ability to add, update, remove blog posts

-   Ability to approve or remove blog comments

-   Log-out feature for admin users

## Installation

Excute the following command in the docker folder

```
docker-compose up -d
```

Install Container interface for dependency injection support
```
docker exec -it derrick-app bash
composer require psr/container
```

Import SQL files "dblog.sql" into MySQL databases (access via PHPMyAdmin http://127.0.0.1:8080)

Navigate to homepage: http://127.0.0.1:8000

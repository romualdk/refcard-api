# Stack

* Mezzio

  PSR-15 Middleware

  https://docs.mezzio.dev/

* mtymek/blast-base-url

  Using Mezzio from subdirectory

  https://docs.mezzio.dev/mezzio/v3/cookbook/using-a-base-path/#mtymek-blast-base-url

* SleekDB

  NoSQL database

  https://github.com/rakibtg/SleekDB

* Manual API tests

  ARC - Advanced REST Client

  https://github.com/advanced-rest-client/arc-electron/releases

## Infos

### PUT request body

To enable PUT request body `BodyParamsMiddleware` is used in `config/pipeline.php`
```
$app->pipe(BodyParamsMiddleware::class);
```

### Use from subdirectory

To use from subdirecotory `mtymek/blast-base-url` is used in `config/pipeline.php`
```
$app->pipe(\Blast\BaseUrl\BaseUrlMiddleware::class);
```

# Refcard API

Based on https://github.com/gothinkster/realworld/tree/master/api

1. [Leagues](#leagues)
    1. [Get one](#get-one)
    1. [Get all](#get-all)
    1. [Create](#create)
    1. [Update](#update)
    1. [Delete](#delete)
1. [Teams](#teams)
    1. [List](#list-teams)
    1. [Create](#create-team)
    1. [Read](#read-team)
    1. [Update](#update-team)
    1. [Delete](#delete-team)
1. [Players](#players)
    1. [Create](#create-player)
    1. [Read](#read-player)
    1. [Update](#update-player)
    1. [Delete](#delete-player)

## General

Success returns `200 OK`

Failure returns `404 Not Found`

## Leagues

### Get one

*Request:*

```
GET /api/leagues/:id
```

*Response on SUCCESS:*

```
200 OK
```
```JSON
{
  "id": 1,
  "name": "Pruszkowska Liga Szóstek Piłkarskich",
  "city": "Pruszków"
}
```

*Response on FAILURE:*

```
404 Not Found
```

### Get all

*Request:*

```
GET /api/leagues
```

*Response on SUCCESS:*

```
200 OK
```
```JSON
[
  {
    "id": 1,
    "name": "Pruszkowska Liga Szóstek Piłkarskich",
    "city": "Pruszków"
  },
  {
    "id": 2,
    "name": "Nowodworka Liga Piłki Nożnej",
    "city": "Nowy Dwór Mazowiecki"
  }
]
```

*Response on FAILURE or EMPTY:*
```
404 Not Found
```


### Create

*Request:*

```
POST /api/leagues
```
```JSON
{
  "name": "Pruszkowska Liga Szóstek Piłkarskich",
  "city": "Pruszków"
}
```

*Response on SUCCESS:*

```
200 OK
```
```JSON
{
  "id": 1,
  "name": "Pruszkowska Liga Szóstek Piłkarskich",
  "city": "Pruszków"
}
```

*Response on FAILURE:*
```
404 Not Found
```

### Update

*Request:*

```
PUT /api/leagues/:id
```
```JSON
{
  "name": "Pruszkowska Liga Szóstek Piłkarskich",
  "city": "Pruszków"
}
```

*Response on SUCCESS:*

```
200 OK
```
```JSON
{
  "id": 1,
  "name": "Pruszkowska Liga Szóstek Piłkarskich",
  "city": "Pruszków"
}
```

*Response on FAILURE:*

```
404 Not Found
```

### Delete

*Request:*

```
DELETE /api/leagues/:id
```

*Response on SUCCESS:*

```
200 OK
```

*Response on FAILURE:*

```
404 Not Found
```

---------

## Teams - TODO

### List Teams

`GET /api/:league_slug/teams`

RESPONSE:
```JSON
{
  "teams": [
    { "id": 0, "name": "Mantika", "numberOfPlayers": 12 },
    { "id": 1, "name": "Megameble", "numberOfPlayers": 9 }
  ]
}
```

### Create Team

`POST /api/:league_slug/team`

REQUEST:
```JSON
{
"team": { "name": "Sznajder" }
}
```

RESPONSE: returns `Team`

### Read Team

`GET /api/:league_slug/team/:team_id`

RESPONSE:
```JSON
{
  "name": "Megameble",
  "team": { "id": 1, "name": "Megameble" },
  "players": [
    { "id": 0, "name": "Czerny Konrad" },
    { "id": 1, "name": "Czerny Krzysztof" },
    { "id": 2, "name": "Jerdal Rafał" },
    { "id": 3, "name": "Maciejec Kuba" },
    { "id": 4, "name": "Sterlus Paweł" },
    { "id": 5, "name": "Sztyk Mateusz" },
    { "id": 6, "name": "Sztyk Piotr" },
    { "id": 7, "name": "Zalewski Piotrek" },
    { "id": 8, "name": "Łata Tomasz" }
  ]
}
```

### Update Team

`PUT /api/:leage_slug/team/:team_id`

REQUEST: 

```JSON
{
  "team": { "name": "Megameble" }
}
```

RESPONSE: returns `Team`

Accept fields: `name`

### Delete Team

`DELETE /api/:league_slug/team/:team_id`

### Player

#### Create

`POST /api/:league_slug/player/:team_id`

REQUEST:
```JSON
{
  "player": { "name": "Czerny Konrad" }
}
```

RESPONSE: returns `Player`

#### Read

`GET /api/:league_slug/player/:player_id`

RESPONESE:

```JSON
{
  "player": { "id": 0, "name": "Czerny Konrad" }
}
```

#### Update

`PUT /api/:leage_slug/player`

REQUEST: 

```JSON
{
  "player": { "name": "Czerny Konrad" }
}
```

RESPONSE: returns `Player`

Accept fields: `name`

#### Delete

`DELETE /api/:league_slug/player/:player_id`













# refcard-api

## Database

### Player
```
id
email
password
name
surname
```

### Team
```
id
slug
name
city
```

### Player Team
```
id_player
id_team
```

### League
```
id
slug
name
city
```

### Season
```
id
slug
name
```

### League Season
```
id_league
id_season
```

### League Team
```
id_league
id_team
```

### Game
```
id
slug
id_league
id_season
id_team1
id_team2
score1
score2
date
id_referee
time
notes
ongoing
archived
deleted
createdAt
updatedAt
id_author
```

## API

Based on https://github.com/gothinkster/realworld/tree/master/api

## JSON Objects returned by API:

Make sure the right content type like `Content-Type: application/json; charset=utf-8` is correctly returned.

### User (for authentication)

```JSON
{
  "user": {
    "email": "r.kowalczyk@example.com",
    "token": "jwt.token.here",
    "name": "Romuald",
    "surname": "Kowalczyk"
  }
}
```

### Profile

```JSON
{
  "profile": {
    "email": "r.kowalczyk@example.com",
    "name": "Romuald",
    "surname": "Kowalczyk"
  }
}
```

### Single game

`time` is in seconds

file: `2020-10-24_1315 Sznajder Megameble PLSP-OS Pruszkow.xml`

```JSON
{
  "game": {
    "slug": "202010241315-sznajder-megameble-plsp-os-pruszkow",
    "createdAt": "2020-10-24T09:22:56.637Z",
    "updatedAt": "2020-10-24T09:58:51.128Z",
    "author": {
      "email": "grzesiek@example.com",
      "name": "Grzesiek",
      "surname": ""
    },
    "date": "2020-10-24T13:15:00.000Z",
    "time": 1448,
    "ongoing": false,
    "archived": false,
    "league": {
      "slug": "plsp-os",
      "name": "Pruszkowska Liga Szóstek Piłkarskich - Osiedle Staszica",
      "email": "liga.szostek.pruszkow@gmail.com",
      "city": "Pruszków"
    },
    "season": { "name": "VIII kolejka 24-25.X.2020" },
    "referee": {
      "name": "Grzesiek",
      "surname": "", 
      "team": "Kings"
    },
    "notes": "",
    "score": {
      "team1": 0,
      "team2": 1
    },
    "team1": {
      "slug": "sznajder",
      "name": "Sznajder",
      "players": [
        { "name": "Łukasz", "surname": "Chodowski" },
        { "name": "Dominik", "surname": "Czubek" },
        { "name": "Marcin", "surname": "Grabowski" },
        { "name": "Robert", "surname": "Protasiuk" },
        { "name": "Kamil", "surname": "Rutka" },
        { "name": "Marcin", "surname": "Stachowicz" },
        { "name": "Michał", "surname": "Sęp" },
        { "name": "Artur", "surname": "Wiśniewski" }
      ]
    },
    "team2": {
      "slug": "megameble",
      "name": "Megameble",
      "players": [
        { "name": "Konrad", "surname": "Czerny" },
        { "name": "Krzysztof", "surname": "Czerny" },
        { "name": "Rafał", "surname": "Jerdal" },
        { "name": "Kuba", "surname": "Maciejec" },
        { "name": "Paweł", "surname": "Sterlus" },
        { "name": "Mateusz", "surname": "Sztyk" },
        { "name": "Piotr", "surname": "Sztyk" },
        { "name": "Piotrek", "surname": "Zalewski" },
        { "name": "Tomasz", "surname": "Łata" }
      ]
    },
    "events": [
      {
        "createdAt": "2020-10-24T09:22:56.637Z",
        "time": 0,
        "type": "start",
        "player": null,
        "team": null
      },
      {
        "createdAt": "2020-10-24T09:36:56.637Z",
        "time": 0,
        "type": "goal",
        "player": { "name": "Sztyk Mateusz" },
        "team": { "name": "Megameble" }
      },
      {
        "createdAt": "2020-10-24T09:41:51.364Z",
        "time": 0,
        "type": "penalty5min",
        "player": { "name": "Czubek Dominik" },
        "team": { "name": "Sznajder" }
      }
    ]
  }
}
```
### Multiple games

```JSON
{
  "games": [
    {
      "slug": "202010241315-sznajder-megameble-plsp-os-pruszkow",
      "createdAt": "2020-10-24T09:22:56.637Z",
      "updatedAt": "2020-10-24T09:58:51.128Z",
      "author": {
        "email": "grzesiek@example.com",
        "name": "Grzesiek",
        "surname": ""
      },
      "date": "2020-10-24T13:15:00.000Z",
      "time": 1448,
      "ongoing": false,
      "archived": false,
      "league": {
        "slug": "plsp-os",
        "name": "Pruszkowska Liga Szóstek Piłkarskich - Osiedle Staszica",
        "email": "liga.szostek.pruszkow@gmail.com",
        "city": "Pruszków"
      },
      "season": { "name": "VIII kolejka 24-25.X.2020" },
      "referee": {
        "name": "Grzesiek",
        "surname": "", 
        "team": "Kings"
      },
      "notes": "",
      "score": {
        "team1": 0,
        "team2": 1
      },
      "team1": {
        "slug": "sznajder",
        "name": "Sznajder"
      },
      "team2": {
        "slug": "megameble",
        "name": "Megameble"
      }
    }
  ]
}
```
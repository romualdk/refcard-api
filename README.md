# refcard-api

## API

Based on https://github.com/gothinkster/realworld/tree/master/api

## JSON Objects returned by API:

Make sure the right content type like Content-Type: application/json; charset=utf-8 is correctly returned.

### User

```JSON
{
  "user": {
    "email": "r.kowalczyk@example.com",
    "token": "jwt.token.here",
    "name": "Romuald",
    "surname": "Kowalczyk",
    "image": null
  }
}
```

### Single game

`time` is in seconds

file: `2020-10-24_1315 - Sznajder Megameble - PLSP-OS Pruszkow`

```JSON
{
  "game": {
    "slug": "202010241315-sznajder-megameble-plsp-os-pruszkow",
    "createdAt": "2020-10-24T09:22:56.637Z",
    "updatedAt": "2020-10-24T09:58:51.128Z",
    "author": {
      "email": "grzesiek@example.com",
      "name": "Grzesiek (Kings)"
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
    "referee": { "name": "Grzesiek Kings" },
    "notes": "",
    "score": {
      "team1": 0,
      "team2": 1
    },
    "team1": {
      "slug": "sznajder",
      "name": "Sznajder",
      "players": [
        { "name": "Chodowski Łukasz" },
        { "name": "Czubek Dominik" },
        { "name": "Grabowski Marcin" },
        { "name": "Protasiuk Robert" },
        { "name": "RutkaKamil" },
        { "name": "Stachowicz Marcin" },
        { "name": "Sęp Michał" },
        { "name": "Wiśniewski Artur" }
      ]
    },
    "team2": {
      "slug": "megameble",
      "name": "Megameble",
      "players": [
        { "name": "Czerny Konrad" },
        { "name": "Czerny Krzysztof" },
        { "name": "Jerdal Rafał" },
        { "name": "Maciejec Kuba" },
        { "name": "Sterlus Paweł" },
        { "name": "Sztyk Mateusz" },
        { "name": "Sztyk Piotr" },
        { "name": "Zalewski Piotrek" },
        { "name": "Łata Tomasz" }
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
   
  ]
}
```
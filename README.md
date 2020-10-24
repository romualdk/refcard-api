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

### Single match

`time` is elapsed time in seconds

```JSON
{
  "id": 0,
  "createdAt": "2020-10-24T09:22:56.637Z",
  "updatedAt": "2020-10-24T09:58:51.128Z",
  "author": {
    "id": 0,
    "email": "grzesiek@example.com",
    "name": "Grzegorz",
    "surname": "Ślusarczyk", 
    "team": "Kings Team",
    "image": null
  },
  "date": "2020-10-24",
  "time": 1448,
  "ongoing": false,
  "archived": false,
  "notes": "VIII kolejka 24-25.X.2020",
  "league": {
    "id": 0,
    "name": "Pruszkowska Liga Szóstek",
    "image": "https://s2.fbcdn.pl/9/clubs/56529/templates/73055/img/user_top.png?version=1410174499"
  },
  "referee": {
    "id": 0,
    "email": "grzesiek@example.com",
    "name": "Grzegorz",
    "surname": "Ślusarczyk", 
    "team": "Kings Team",
    "image": null
  },
  "team1": {
    "id": 0,
    "name": "Sznajder",
    "image": null,
    "players": [
      {
        "id": null,
        "name": "Łukasz",
        "surname": "Chodowski",
        "image": null
      },
      {
        "id": null,
        "name": "Dominik",
        "surname": "Czubek",
        "image": null
      },
      {
        "id": 2,
        "name": "Marcin",
        "surname": "Grabowski",
        "image": null
      },
      {
        "id": 3,
        "name": "Robert",
        "surname": "Protasiuk",
        "image": null
      },
      {
        "id": 4,
        "name": "Kamil",
        "surname": "Rutka",
        "image": null
      },
      {
        "id": 5,
        "name": "Marcin",
        "surname": "Stachowicz",
        "image": null
      },
      {
        "id": 6,
        "name": "Michał",
        "surname": "Sęp",
        "image": null
      },
      {
        "id": 7,
        "name": "Artur",
        "surname": "Wiśniewski",
        "image": null
      }
    ]
  },
  "team2": {
    "id": 1,
    "name": "Megameble",
    "image": null,
    "players": [
      {
        "id": 8,
        "name": "Konrad",
        "surname": "Czerny",
        "image": null
      },
      {
        "id": 9,
        "name": "Krzysztof",
        "surname": "Czerny",
        "image": null
      },
      {
        "id": 10,
        "name": "Rafał",
        "surname": "Jerdal",
        "image": null
      },
      {
        "id": 11,
        "name": "Kuba",
        "surname": "Maciejec",
        "image": null
      },
      {
        "id": 12,
        "name": "Paweł",
        "surname": "Sterlus",
        "image": null
      },
      {
        "id": 13,
        "name": "Mateusz",
        "surname": "Sztyk",
        "image": null
      },
      {
        "id": 14,
        "name": "Piotr",
        "surname": "Sztyk",
        "image": null
      },
      {
        "id": 15,
        "name": "Piotrek",
        "surname": "Zalewski",
        "image": null
      },
      {
        "id": 16,
        "name": "Tomasz",
        "surname": "Łata",
        "image": null
      }
    ]
  },
  "score": {
    "team1": 0,
    "team2": 1
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
      "player": {
        "id": 13,
        "name": "Mateusz",
        "surname": "Sztyk",
        "image": null
      },
      "team": {
        "id": 1,
        "name": "Megameble",
        "image": null
      }
    },
    {
      "createdAt": "2020-10-24T09:41:51.364Z",
      "time": 0,
      "type": "penalty5min",
      "player": {
        "id": null,
        "name": "Dominik",
        "surname": "Czubek",
        "image": null
      },
      "team": {
        "id": 0,
        "name": "Sznajder",
        "image": null
      }
    }
  ]
}
```


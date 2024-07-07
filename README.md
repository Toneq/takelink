# TMDB API Laravel

### Filmy

- **GET** `/api/movies`
  - Parametry zapytania: `language` (opcjonalny, domyślnie `en`)
  - Przykład: `/api/movies?language=pl`
  - Zwraca:
    ```json
    [
      {
        "id": 1,
        "movie_id": 123,
        "title": "Tytuł filmu",
        "overview": "Opis filmu",
        "genres": [
          {
            "id": 28,
            "name": "Akcja"
          },
          {
            "id": 12,
            "name": "Przygoda"
          }
        ]
      }
    ]
    ```

### Seriale

- **GET** `/api/series`
  - Parametry zapytania: `language` (opcjonalny, domyślnie `en`)
  - Przykład: `/api/series?language=pl`

### Gatunki

- **GET** `/api/genres`
  - Parametry zapytania: `language` (opcjonalny, domyślnie `en`)
  - Przykład: `/api/genres?language=pl`

## Instalacja i uruchomienie

1. Sklonuj repozytorium i zainstaluj zależności:
   ```sh
   git clone git@github.com:Toneq/takelink.git
   cd your-repo-directory
   composer install
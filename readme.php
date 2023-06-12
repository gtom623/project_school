# Projekt "School" w CakePHP

## Wprowadzenie

Projekt "School" jest aplikacją internetową stworzoną za pomocą frameworka CakePHP.

## Funkcjonalności

 
1. **Zarządzanie Uczniami**: Możliwość dodawania, edycji, i przeglądania informacji o uczniach.
2. **Zarządzanie Nauczycielami**: Możliwość dodawania, edycji, i przeglądania informacji o nauczycielach.
3. **Zarządzanie Klasami**: Możliwość dodawania, edycji, i przeglądania informacji o klasach.
4. **API do Pobierania Danych**: Aplikacja posiada API, które umożliwia pobieranie informacji o nauczycielach i uczniach w formacie JSON. 
Możliwe jest wykorzystanie tego API do integracji z innymi systemami lub do tworzenia aplikacji klienckich.
5. **Dokumentacja API za pomocą Swagger UI**: Aplikacja zawiera interfejs Swagger UI, który umożliwia przeglądanie i testowanie endpointów API w przyjazny dla użytkownika sposób.
 Użytkownicy mogą przeglądać dostępne zasoby API, strukturę żądań i odpowiedzi, jak również mogą wykonywać żądania bezpośrednio z poziomu interfejsu Swagger UI.

## Wymagania

- PHP >= 7.3
- MySQL lub inny kompatybilny system zarządzania bazami danych
- Composer


## Instalacja

1. Sklonuj repozytorium na swój serwer lub lokalne środowisko deweloperskie.
    ```
    git clone [URL_REPOZYTORIUM]
    ```
2. Przejdź do katalogu projektu.
    ```
    cd school
    ```
3. Zainstaluj zależności za pomocą Composer.
    ```
    composer install
    ```
4. Skonfiguruj połączenie z bazą danych, edytując plik `config/app.php`.
5. Uruchom migracje, aby utworzyć tabele w bazie danych.
    ```
    bin/cake migrations migrate
    ```
6. Uruchom serwer deweloperski.
    ```
    bin/cake server
    ```

## Użycie

Po uruchomieniu serwera, otwórz przeglądarkę i przejdź do adresu `http://localhost:8765` aby uzyskać dostęp do aplikacji.

## Wsparcie

Jeśli napotkasz na problemy lub masz pytania dotyczące projektu, skont
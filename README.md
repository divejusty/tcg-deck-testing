## About the TCG Deck Tester

The goal of this software is to allow for easy registration of a deck's performance when testing.

## Development setup

The development environment is run using Laravel Sail.
If you want to run the app locally, make sure Docker Desktop is installed.
If that's the case, it's a matter of making sure the composer dependencies are installed and then running:

```
./vendor/bin/sail up
./vendor/bin/sail npm run dev
```

This will expose the app on `localhost` with hot module reloading available.
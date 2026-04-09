#!/bin/sh

ROOT=$(git rev-parse --show-toplevel)

FILES=$(git diff --cached --name-only --diff-filter=ACM)

PHP_FILES=$(echo "$FILES" | grep -E "^src/.*\.php$")

if [ -n "$PHP_FILES" ]; then
  echo "Running Laravel Pint..."
  (
    cd "$ROOT/src" || exit 1
    echo "$PHP_FILES" | sed 's|^src/||' | xargs ./vendor/bin/pint
  )
  echo "$PHP_FILES" | xargs git add
fi

FRONT_FILES=$(echo "$FILES" | grep -E "^src/.*\.(blade\.php|js|ts|jsx|tsx|css|scss|json|md)$")

if [ -n "$FRONT_FILES" ]; then
  echo "Running Prettier..."
  (
    cd "$ROOT/src" || exit 1
    echo "$FRONT_FILES" | sed 's|^src/||' | xargs ./node_modules/.bin/prettier --write
  )
  echo "$FRONT_FILES" | xargs git add
fi

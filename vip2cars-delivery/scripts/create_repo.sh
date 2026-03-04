#!/usr/bin/env bash
set -e
if [ -z "$1" ]; then
  echo "Usage: $0 <remote_repo_url>";
  exit 1;
fi
REMOTE=$1
git init
git add .
git commit -m "Entrega VIP2CARS"
git branch -M main
git remote add origin "$REMOTE"
git push -u origin main
echo "Pushed to $REMOTE"

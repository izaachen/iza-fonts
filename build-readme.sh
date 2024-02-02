#!/bin/sh

# This script is used to build the README.md file for the project.

# delete the README.md file if it exists
rm -f README.md

# Concat the readme files together
cat src/readme/README-base.md >> README.md
cat src/readme/README-desktop.md >> README.md
cat src/readme/README-web.md >> README.md
cat src/readme/README-wordpress.md >> README.md

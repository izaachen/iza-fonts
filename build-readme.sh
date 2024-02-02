#!/bin/sh

# This script is used to build the README.md file for the project.

# delete the README.md file if it exists
rm -f README.md

# Concat the readme files together
cat readme/README-header.md >> README.md
cat readme/README-usecase.md >> README.md
cat readme/README-content.md >> README.md
cat readme/README-desktop.md >> README.md
cat readme/README-web.md >> README.md
cat readme/README-wordpress.md >> README.md

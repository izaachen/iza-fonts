#!/bin/sh

# This script is used to build the desktop version of the font package

# Create output dir at dist/font-desktop if not exist
mkdir -p dist

# Clear contents of dist/font-desktop
rm -rf dist/font-desktop*

# Read the version number from the package.json file
VERSION=$(node -p -e "require('./package.json').version")

buildDir=dist/font-desktop-$VERSION

# Create the buildDir
mkdir -p $buildDir

# Refresh the readme
./build-readme.sh

# Copy the README.md file to the buildDir
cp README.md $buildDir

# Copy all files from src/fonts/*/desktop/* to dist/font-desktop/font-desktop-<version>
cp -r src/fonts/*/desktop/* $buildDir

# Create the release zip file
cd dist || exit 1

# Use zip if available, else use tar
zip -r font-desktop-$VERSION.zip font-desktop-$VERSION

cd .. || echo exit 1

# Remove the buildDir
rm -rf $buildDir

# Print the release zip file path
echo "dist/font-desktop-$VERSION.zip"

exit 0

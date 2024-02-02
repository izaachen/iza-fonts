#!/bin/sh

# This script is used to build the desktop version of the font package

# Create output dir at dist/font-web if not exist
mkdir -p dist

# Clear contents of dist/font-web
rm -rf dist/font-web*

# Read the version number from the package.json file
VERSION=$(node -p -e "require('./package.json').version")

buildDir=dist/font-web-$VERSION

# Create the buildDir
mkdir -p $buildDir

# Refresh the readme
./build-readme.sh

# Copy the README.md file to the buildDir
cp README.md $buildDir

cp -r src/fonts $buildDir

# Remove all desktop subdirectories
rm -rf $buildDir/fonts/*/desktop

# Copy the CSS folder to the buildDir
cp -r src/css $buildDir

# Move the font-index.css to the upper directory
mv $buildDir/css/font-index.css $buildDir/font-index.css

# Copy the package.json file to the buildDir
cp package.json $buildDir

# Create the release zip file
cd dist || exit 1

# Use zip if available, else use tar
zip -r font-web-$VERSION.zip font-web-$VERSION

cd .. || echo exit 1

# Remove the buildDir
rm -rf $buildDir

# Print the release zip file path
echo "dist/font-web-$VERSION.zip"

exit 0

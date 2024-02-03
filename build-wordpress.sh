#!/bin/sh

# This script is used to build the desktop version of the font package

# Create output dir at dist/font-wordpress if not exist
mkdir -p dist

# Read the version number from the package.json file
VERSION=$(node -p -e "require('./package.json').version")
contentDir=iza-wordpress-fonts
buildDir=dist/$contentDir

# Clear contents of dist/font-wordpress
rm -rf $buildDir*

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

# Copy the wordpress plugin files to the buildDir
cp -r src/wordpress-plugin/* $buildDir

# Update variables in iza-wordpress-fonts.php from package.json
# //
# Replace {{ package.version }}
VERSION=$(node -p -e "require('./package.json').version" | sed 's/[&/]/\\&/g')
sed -i'' -e "s/{{ package.version }}/$VERSION/g" "$buildDir/iza-wordpress-fonts.php"

# Replace {{ package.homepage }}
HOMEPAGE=$(node -p -e "require('./package.json').homepage" | sed 's/[&/]/\\&/g')
sed -i'' -e "s/{{ package.homepage }}/$HOMEPAGE/g" "$buildDir/iza-wordpress-fonts.php"

# Replace {{ package.author }}
AUTHOR=$(node -p -e "require('./package.json').author" | sed 's/[&/]/\\&/g')
sed -i'' -e "s/{{ package.author }}/$AUTHOR/g" "$buildDir/iza-wordpress-fonts.php"

# Replace {{ package.description }}
DESCRIPTION=$(node -p -e "require('./package.json').description" | sed 's/[&/]/\\&/g')
sed -i'' -e "s/{{ package.description }}/$DESCRIPTION/g" "$buildDir/iza-wordpress-fonts.php"



# Create the release zip file
cd dist || exit 1

# Use zip if available, else use tar
zip -r fonts-wordpress-$VERSION.zip $contentDir

cd .. || echo exit 1

# Remove the buildDir
rm -rf $buildDir

# Print the release zip file path
echo "dist/fonts-wordpress-$VERSION.zip"

exit 0

#!/bin/bash

# Extract the version from manifest.json
VERSION=$(grep '"version"' manifest.json | sed -E 's/.*"version": *"([^"]+)".*/\1/')

# Check if the version was extracted successfully
if [ -z "$VERSION" ]; then
  echo "Failed to extract version from manifest.json"
  exit 1
fi

# Define the name of the zip file with the version
OUTPUT_DIR="dist"
BASE_NAME="bloxthemes-v$VERSION.zip"
ZIP_FILE="$OUTPUT_DIR/$BASE_NAME"

# Create the output directory if it doesn't exist
mkdir -p "$OUTPUT_DIR"

# Check if the zip file already exists and delete it
if [ -f "$ZIP_FILE" ]; then
  echo "Removing existing $ZIP_FILE"
  rm "$ZIP_FILE"
fi

# Add js, html, and manifest.json to the zip file
echo "Creating $ZIP_FILE with js/, html/, and manifest.json"
zip -r "$ZIP_FILE" js html manifest.json

# Check if the zip file was created successfully
if [ $? -eq 0 ]; then
  echo "Successfully created $ZIP_FILE"
else
  echo "Failed to create $ZIP_FILE"
fi

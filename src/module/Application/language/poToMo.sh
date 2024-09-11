#!/bin/bash

# Directory where your .po files are located
DIR="/home/gautrea221/Projects/smile_3/src/module/Application/language/"

# Loop over all .po files in the directory and its subdirectories
find $DIR -name "*.po" -type f -print0 | while IFS= read -r -d '' file
do
    # Get the base name of the file, without the .po extension
    base="${file%.po}"

    # Compile the .po file into a .mo file
    msgfmt "$file" -o "$base.mo"
done
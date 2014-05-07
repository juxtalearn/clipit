#!/bin/bash
rm -rf clipit_reference/*
phpdoc -d engine/classes,mod/clipit_api,mod/urjc_backend -t clipit_reference
echo "DirectoryIndex index.html" > clipit_reference/.htaccess
cd clipit_reference
git commit -a -m 'auto-commit done by run_phpdoc.sh'
git push

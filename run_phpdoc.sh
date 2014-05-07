rm -rf clipit_reference
phpdoc -d engine/classes,mod/clipit_api,mod/urjc_backend -t clipit_reference
echo "DirectoryIndex index.html" > clipit_reference/.htaccess

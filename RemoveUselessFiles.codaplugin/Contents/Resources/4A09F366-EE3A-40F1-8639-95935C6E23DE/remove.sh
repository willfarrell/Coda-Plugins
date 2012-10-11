#!/bin/bash
if [ "$CODA_SITE_LOCAL_PATH" != "" ]; then
    cd "$CODA_SITE_LOCAL_PATH"
    # http://www.westwind.com/reference/os-x/invisibles.html

    find . -name 'Thumbs.db' -exec rm -rf {} \; # Windows
    find . -name '.DS_Store' -exec rm -rf {} \; # Mac OSX
    find . -name '._*' -exec rm -rf {} \; # Mac OSX resource forks

    find . -name '_notes' -exec rm -rf {} \; # Dreamweaver
    #find . -name '.ceid' -exec rm -rf {} \; # PogoPlug
    #find . -name '.cedata' -exec rm -rf {} \; # PogoPlug
    
    find . -name 'error_log' -exec rm -rf {} \; # Apache via MAMP
    find . -regex '^core.[0-9]{4,}$' -exec rm -rf {} \; # core dumps
fi
exit 0
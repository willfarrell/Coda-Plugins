#!/bin/bash
if [ "$CODA_SITE_LOCAL_PATH" != "" ]; then
	cd "$CODA_SITE_LOCAL_PATH"
	find . -name '*.DS_Store' -exec rm -rf '{}' \;
    find . -name 'Thumbs.db' -exec rm -rf '{}' \;
    find . -name '_notes' -exec rm -rf '{}' \;
    find . -name 'error_log' -exec rm -rf '{}' \;
    find . -regex '^core.[0-9]{4,}$' -exec rm -rf '{}' \;

    find . -regex '^\._(.*)$' -exec rm -rf '{}' \;
fi
exit 0
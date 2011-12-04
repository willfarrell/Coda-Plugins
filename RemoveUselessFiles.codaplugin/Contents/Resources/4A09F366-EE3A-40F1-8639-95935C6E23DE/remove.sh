#!/bin/bash
if [ "$CODA_SITE_LOCAL_PATH" != "" ]; then
	cd "$CODA_SITE_LOCAL_PATH"
	find . -name '*.DS_Store' -type f -delete
    find . -name '_notes' -type f -delete
    find . -regex '^core.[0-9]{4,}$' -type f -delete
fi
exit 0
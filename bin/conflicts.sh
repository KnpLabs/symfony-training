#!/bin/bash

conflicts = $(git diff --check | grep -i conflict)

if [[ $(conflicts) ]]; then
    echo "There is conflicts !"

    for c in conflicts do
        echo c >> rebase.md
    done
else
    echo "No conflicts"
fi
#!/bin/bash
APPLICATION_PATH=$(cd "$(dirname "$0")/../application" && pwd)
rm -vrf "$APPLICATION_PATH/../temp/"*

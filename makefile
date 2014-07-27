#!/usr/bin/env make
# DESCRIPTION
#	Project utility to install client/server, deploy, etc.
#
# USAGE
#	curl -L http://git.edouard-lopez.com:81/root/mast-we.git/raw/master/makefile | make -f -
#
# AUTHOR
#	Édouard Lopez <dev+mast-web@edouard-lopez.com>

ifneq (,)
This makefile requires GNU Make.
endif

# force use of Bash
SHELL := /bin/bash
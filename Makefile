#
# Makefile for SQL Ledger Xelera LaTex templates
# with tf_engine_tt+yaml
#

# the optput directories
WEBDIR=node103:/home/sites/www.xelera.eu/web/html/static/doc/legambiente-lombardia
USERDOC_DIR=doc/user

all: userdoc

userdoc: html html5 pdf

html5:
	rst2html5 -l it --strip-comments $(USERDOC_DIR)/user-manual-it.rst > $(USERDOC_DIR)/user-manual-it-html5.html
	rst2html5 -l it --strip-comments $(USERDOC_DIR)/terms+conditions-it.rst > $(USERDOC_DIR)/terms+conditions-it-html5.html

html:
	rst2html -l it --strip-comments --embed-stylesheet $(USERDOC_DIR)/user-manual-it.rst > $(USERDOC_DIR)/user-manual-it.html
	rst2html -l it --strip-comments --embed-stylesheet $(USERDOC_DIR)/terms+conditions-it.rst > $(USERDOC_DIR)/terms+conditions-it.html

pdf:
	rst2latex --strip-comments -l it --no-section-numbering --use-latex-toc --stylesheet xelera-rst.sty --table-style=booktabs -i utf-8 -o utf-8 $(USERDOC_DIR)/user-manual-it.rst > $(USERDOC_DIR)/user-manual-it.tex
	cd $(USERDOC_DIR) && pdflatex user-manual-it ; pdflatex user-manual-it

deploy:
	scp $(USERDOC_DIR)/user-manual-it.html $(WEBDIR)/cms-circoli-user-manual-it.html
	scp -r $(USERDOC_DIR)/images  $(WEBDIR)/
	scp $(USERDOC_DIR)/terms+conditions-it.html $(WEBDIR)/cms-circoli-terms+conditions-it.html

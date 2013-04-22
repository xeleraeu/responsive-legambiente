#
# Makefile for SQL Ledger Xelera LaTex templates
# with tf_engine_tt+yaml
#

# the optput directories
WEBDIR='node103:/home/sites/www.xelera.eu/web/html/static/doc/legambiente-lombardia'

all: html html5 pdf

html5:
	rst2html5 -l it --strip-comments user-manual-it.rst > user-manual-it-html5.html
	rst2html5 -l it --strip-comments terms+conditions-it.rst > terms+conditions-it-html5.html

html:
	rst2html -l it --strip-comments --embed-stylesheet user-manual-it.rst > user-manual-it.html
	rst2html -l it --strip-comments --embed-stylesheet terms+conditions-it.rst > terms+conditions-it.html

pdf:
	rst2latex --strip-comments -l it --no-section-numbering --use-latex-toc --stylesheet xelera-rst.sty --table-style=booktabs -i utf-8 -o utf-8 user-manual-it.rst > user-manual-it.latex
	pdflatex user-manual-it.latex
	pdflatex user-manual-it.latex

deploy:
	scp user-manual-it.html $(WEBDIR)/cms-circoli-user-manual-it.html
	scp -r images  $(WEBDIR)/images
	scp terms+conditions-it.html $(WEBDIR)/cms-circoli-terms+conditions-it.html

#
# Makefile for SQL Ledger Xelera LaTex templates
# with tf_engine_tt+yaml
#

# the optput directories
#ITDIR=templates/xelera
#ENDIR=$(ITDIR)/EN

all: html html5 pdf

html5:
	rst2html5 -l it user-manual-it.rst > user-manual-it-html5.html

html:
	rst2html -l it user-manual-it.rst > user-manual-it.html

pdf:
	rst2latex --strip-comments -l it --no-section-numbering --use-latex-toc --stylesheet xelera-rst.sty --table-style=booktabs -i utf-8 -o utf-8 user-manual-it.rst > user-manual-it.latex
	pdflatex user-manual-it.latex
	pdflatex user-manual-it.latex


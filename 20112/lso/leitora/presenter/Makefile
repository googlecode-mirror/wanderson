all: bib pdf

dvi:
	latex document.tex

ps: dvi
	dvips document.dvi

pdf: ps
	ps2pdf document.ps

bib: dvi
	bibtex document

clean:
	rm -vrf $$(ls | grep -v '\(^Makefile\|tex$$\|bib$$\|sty$$\)')

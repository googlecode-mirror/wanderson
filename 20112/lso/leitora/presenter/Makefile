all:
	latex document.tex && dvips document.dvi && ps2pdf document.ps

clean:
	rm -vrf $$(ls | grep -v '\(^Makefile\|tex$$\)')

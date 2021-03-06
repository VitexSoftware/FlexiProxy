all: fresh build install

fresh:
	echo fresh

install: 
	echo install
	
build:
	echo build

clean:
	rm -rf debian/flexiproxy debian/flexiproxy-apache debian/flexiproxy-core debian/flexiproxy-custom-columns debian/flexiproxy-custom-columns-api debian/flexiproxy-database debian/flexiproxy-developer debian/flexiproxy-history debian/flexiproxy-logochanger debian/flexiproxy-pricelist-images debian/flexiproxy-custom-menu debian/flexiproxy-pricelist-attachment
	rm -rf debian/*.substvars debian/*.log debian/*.debhelper debian/files debian/debhelper-build-stamp

deb:
	debuild -i -us -uc -b

.PHONY : install
	
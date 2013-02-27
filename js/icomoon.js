/* Use this script if you need to support IE 7 and IE 6. */

window.onload = function() {
	function addIcon(el, entity) {
		var html = el.innerHTML;
		el.innerHTML = '<span style="font-family: \'icomoon\'">' + entity + '</span>' + html;
	}
	var icons = {
			'icon-untitled' : '&#xe000;',
			'icon-untitled-2' : '&#xe001;',
			'icon-untitled-3' : '&#xe002;',
			'icon-untitled-4' : '&#xe003;',
			'icon-untitled-5' : '&#xe004;',
			'icon-untitled-6' : '&#xe005;',
			'icon-untitled-7' : '&#xe006;',
			'icon-untitled-8' : '&#xe007;',
			'icon-untitled-9' : '&#xe008;',
			'icon-untitled-10' : '&#xe009;',
			'icon-untitled-11' : '&#xe00a;',
			'icon-untitled-12' : '&#x50;',
			'icon-untitled-13' : '&#x41;',
			'icon-untitled-14' : '&#x57;',
			'icon-untitled-15' : '&#x53;',
			'icon-untitled-16' : '&#x4e;',
			'icon-untitled-17' : '&#x65;',
			'icon-untitled-18' : '&#x77;',
			'icon-untitled-19' : '&#x45;',
			'icon-untitled-20' : '&#x6e;',
			'icon-untitled-21' : '&#x67;',
			'icon-untitled-22' : '&#x6c;',
			'icon-untitled-23' : '&#x61;',
			'icon-untitled-24' : '&#x64;',
			'icon-search' : '&#xe00b;',
			'icon-grid-view' : '&#xe00d;',
			'icon-filter' : '&#xe00c;'
		},
		els = document.getElementsByTagName('*'),
		i, attr, html, c, el;
	for (i = 0; i < els.length; i += 1) {
		el = els[i];
		attr = el.getAttribute('data-icon');
		if (attr) {
			addIcon(el, attr);
		}
		c = el.className;
		c = c.match(/icon-[^\s'"]+/);
		if (c && icons[c[0]]) {
			addIcon(el, icons[c[0]]);
		}
	}
};
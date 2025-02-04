function wordwrap(str, ope, int, clo, brk) {
	var n = 0;
	var r = '';
	var m = brk;
	var h = str.length;
	while (n + brk < h) {
		r = r + str.slice(n,m) + int;
		n = n + brk;
		m = m + brk;
	}
	r = ope + r + str.slice(m-brk,h) + clo;
	return r;
};

	function VerificarCNPJ(val)
	{		
		if (val.match(/^\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}$/) != null) {
			var val1 = val.substring(0, 2);
			var val2 = val.substring(3, 6);
			var val3 = val.substring(7, 10);
			var val4 = val.substring(11, 15);
			var val5 = val.substring(16, 18);

			var i;
			var number;
			var result = true;

			number = (val1 + val2 + val3 + val4 + val5);

			s = number;

			c = s.substr(0, 12);
			var dv = s.substr(12, 2);
			var d1 = 0;

			for (i = 0; i < 12; i++)
				d1 += c.charAt(11 - i) * (2 + (i % 8));

			if (d1 == 0)
				result = false;

			d1 = 11 - (d1 % 11);

			if (d1 > 9) d1 = 0;

			if (dv.charAt(0) != d1)
				result = false;

			d1 *= 2;
			for (i = 0; i < 12; i++) {
				d1 += c.charAt(11 - i) * (2 + ((i + 1) % 8));
			}

			d1 = 11 - (d1 % 11);
			if (d1 > 9) d1 = 0;

			if (dv.charAt(1) != d1)
				result = false;

			return result;
		}

		return false;
	}

	function VerificarCEP(cep)
	{
		var objER = /^[0-9]{2}.[0-9]{3}-[0-9]{3}$/;

		strCEP = cep.replace(/^s+|s+$/g, '');

		if(strCEP.length > 0)
			{
				if(objER.test(strCEP))
					return true;
				else
					return false;
			}
		else
			return false;
	}

	function VerificarCPF(val) 
	{
		
		if (val.match(/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/) != null) {
			var val1 = val.substring(0, 3);
			var val2 = val.substring(4, 7);
			var val3 = val.substring(8, 11);
			var val4 = val.substring(12, 14);

			var i;
			var number;
			var result = true;

			number = (val1 + val2 + val3 + val4);

			s = number;
			c = s.substr(0, 9);
			var dv = s.substr(9, 2);
			var d1 = 0;

			for (i = 0; i < 9; i++) {
				d1 += c.charAt(i) * (10 - i);
			}

			if (d1 == 0)
				result = false;

			d1 = 11 - (d1 % 11);
			if (d1 > 9) d1 = 0;

			if (dv.charAt(0) != d1)
				result = false;

			d1 *= 2;
			for (i = 0; i < 9; i++) {
				d1 += c.charAt(i) * (11 - i);
			}

			d1 = 11 - (d1 % 11);
			if (d1 > 9) d1 = 0;

			if (dv.charAt(1) != d1)
				result = false;

			return result;
		}

		return false;
	}
// adapt these 2 to whatever you need
	function extractSizeColour(sku) {
	    // this will work more reliably
	    var regex = /_([0-9]{1,3}[A-Za-z]{1,3})(.*)/g,
	        matches = {},
	        match;
	    try {
	        while (match = regex.exec(sku)) {
	            matches.dimension5 = match[2];
	            matches.variant = match[1];
	        }

	    } catch (err) {
	        matches = {
	            dimension5: undefined,
	            variant: undefined
	        };
	    }
	    return matches;
	}

	function extractBrand(name) {
	  var expression = /\b[A-Z]+[a-z]+\b/g;
	  var output = name.match(expression);
	  if (output && output[0]) {
	    return output.join(" ");
	 } else {
	    var ph = name.split(" ");
	    if (ph && ph[0]) {
	      return ph[0];
	    }
	  }
	return "Missing";
	}


	var analyticsCode = window.location.href.indexOf("www.bouxavenue.com") > -1 ? "UA-19175337-1" : "UA-19175337-2";

	// -2 is now setup for test purposes

	(function(i, s, o, g, r, a, m) {
	    i['GoogleAnalyticsObject'] = r;
	    i[r] = i[r] || function() {
	        (i[r].q = i[r].q || []).push(arguments)
	    }, i[r].l = 1 * new Date();
	    a = s.createElement(o),
	        m = s.getElementsByTagName(o)[0];
	    a.async = 1;
	    a.src = g;
	    m.parentNode.insertBefore(a, m)
	})(window, document, 'script', 'https://www.google-analytics.com/analytics.js', '_ga');

	_ga('create', analyticsCode, 'auto');
	_ga('require', 'ec');
	var po_outputTest = po_outputTest || [];
	gle("OnCheckoutStepLoaded", function(data) {
		po_outputTest.push(JSON.parse(JSON.stringify(data)));
	    if (data.StepId == data.Steps.CONFIRMATION && data.IsSuccess) {
	        var countryCode = window.GlobalE && GlobalE.Country ? GlobalE.Country : "GB"
	        _ga('set', 'currencyCode', data.details.customerCurrency);
	        for (var i = 0; i < data.details.products.length; i++) {
	            var matches = extractSizeColour(data.details.products[i].sku);
	            _ga("ec:addProduct", {
	                "id": data.details.products[i].sku,
	                "name": data.details.products[i].name,
	                "category": data.details.products[i].categories && data.details.products[i].categories[0] && data.details.products[i].categories[0].name ? data.details.products[i].categories[0].name : "Missing",
	                "brand": extractBrand(data.details.products[i].name),
	                "variant": matches.variant,
	                "dimension5": matches.dimension5,
	                "price": data.details.products[i].customerPrice, // assuming this is unit cost
	                "quantity": data.details.products[i].quantity,
	                "position": data.details.products[i].cartItemId // mostly redundant but no harm

	            });
	        }

	        _ga("ec:setAction", "purchase", {
	            "id": data.OrderId,
	            "affiliation": "Boux Avenue " + countryCode,
	            "revenue": data.details.customerTotalPrice,
	            "tax": data.details.customerTotalVAT,
	            "shipping": data.details.customerDiscountedShippingPrice

	        });


	        _ga("send", "pageview", '/' + countryCode.toLowerCase() + '/checkout/success');

	    } else {
	        _ga("send", "pageview");
		    console.log("_load");
	    }

	});

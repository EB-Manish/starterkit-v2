(function () {
    // Checkbox click event
    var checkBox = document.querySelectorAll('#product-filter .checkbox');
    for (let i = 0; i < checkBox.length; i++) {
        checkBox[i].addEventListener("click", function () {
            filterProduct();
        });
    }

    pagination();

    // Pagination function
    function pagination() {
        var pagination = document.querySelectorAll('.pagination .page-link');
        for (let i = 0; i < pagination.length; i++) {
            pagination[i].addEventListener("click", function () {
                var pageNo = pagination[i].getAttribute('data-pageno');

                filterProduct(pageNo);
            });
        }
    }

    // Filter product function
    function filterProduct(page = 1) {
        // Output
        var output = document.getElementById('filter-output');
        output.innerHTML = '<button type="button" class="btn btn-primary btn-loading"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10 0C4.824 0 0.553781 3.954 0.0507812 9H2.06836C2.56336 5.06 5.928 2 10 2C14.072 2 17.4366 5.06 17.9316 9H19.9492C19.4452 3.954 15.176 0 10 0ZM0.0507812 11C0.250781 13.008 1.05458 14.8374 2.26758 16.3184L3.6875 14.8984C2.8295 13.7924 2.25136 12.457 2.06836 11H0.0507812ZM16.2715 14.9297C15.8575 15.4547 15.3855 15.9328 14.8555 16.3398L15.8672 18.0742C16.6802 17.4832 17.399 16.7698 18.002 15.9668L16.2715 14.9297ZM5.10352 16.3105L3.68164 17.7324C4.98764 18.8014 6.56592 19.5496 8.29492 19.8516L8.4375 17.8398C7.2005 17.5918 6.06452 17.0595 5.10352 16.3105ZM13.1309 17.3516C12.2949 17.7086 11.3846 17.9285 10.4316 17.9805L10.2891 19.9863C11.6611 19.9473 12.9606 19.621 14.1406 19.082L13.1309 17.3516Z" fill="currentColor" /></svg></button>'

        var categoriesChoices = {};
        var attributesChoices = {};

        // Getting values from catergories checkbox
        var categories = document.querySelectorAll('.section-ecommerce-three .categories input[type=checkbox]');
        for (let i = 0; i < categories.length; i++) {
            if (categories[i].checked) {
                if (!categoriesChoices.hasOwnProperty(categories[i].name))
                    categoriesChoices[categories[i].name] = [categories[i].value];
                else
                    categoriesChoices[categories[i].name].push(categories[i].value);
            }
        }

        // Getting values from atrtributes checkbox
        var attributes = document.querySelectorAll('.section-ecommerce-three .attributes input[type=checkbox]');
        for (let i = 0; i < attributes.length; i++) {
            if (attributes[i].checked) {
                if (!attributesChoices.hasOwnProperty(attributes[i].name))
                    attributesChoices[attributes[i].name] = [attributes[i].value];
                else
                    attributesChoices[attributes[i].name].push(attributes[i].value);
            }
        }

        // Categories data to send in request
        var categoriesData = '';
        for (var key in categoriesChoices) {
            if (categoriesChoices.hasOwnProperty(key)) {
                var categoriesArray = categoriesChoices[key];

                for (let i = 0; i < categoriesArray.length; i++) {
                    categoriesData += '&categoriesChoices%5B' + key + '%5D%5B%5D=' + categoriesArray[i];
                }
            }
        }

        // Attributes data to send in request
        var attributesData = '';
        for (var key in attributesChoices) {
            if (attributesChoices.hasOwnProperty(key)) {
                var attributesArray = attributesChoices[key];

                for (let i = 0; i < attributesArray.length; i++) {
                    attributesData += '&attributesChoices%5B' + key + '%5D%5B%5D=' + attributesArray[i];
                }
            }
        }

        // Page data to send in request
        var pageData = '&pageNo=' + page;

        // Ajax request
        var request = new XMLHttpRequest();
        request.open('POST', starterkit_custom_data.ajax_url, true);
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        request.onreadystatechange = () => {
            if (request.readyState === 4) {
                output.scrollIntoView();
                output.innerHTML = request.response;

                pagination();
            }
        }
        request.send('action=ecommerce_three_filter_products&nonce=' + starterkit_custom_data.ajax_nonce + categoriesData + attributesData + pageData);
    }
    // on click open drop down filter
        var openFilter = document.getElementById('open-filter');
        if(openFilter){
            openFilter.addEventListener("click" , function(){
                var element = document.getElementById("product-filter");
                element.classList.toggle("d-block");
                openFilter.classList.toggle("open");
            });
        }

       
})();

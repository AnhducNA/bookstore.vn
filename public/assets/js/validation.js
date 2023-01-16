function validator(options) {
    var selectorRules = {};

    function validate(inputElement, rule) {
        const errorElement = inputElement.parentElement.querySelector(options.errorSelector);

        let errorMessage;
        // get these rules from selector
        const rules = selectorRules[rule.selector];
        // console.log(rules)
        for (var i = 0; i < rules.length; i++) {
            errorMessage = rules[i](inputElement.value);
            if (errorMessage) break;
        }
        if (errorMessage) {
            errorElement.innerText = errorMessage;
            inputElement.parentElement.classList.add("invalid");
        } else {
            errorElement.innerText = "";
            inputElement.parentElement.classList.remove("invalid");
        }
        console.log(errorMessage);
        // rule
        console.log(rule)
        return errorMessage ? false : true;
    }

    const formElement = document.querySelector(options.form);
    if (formElement) {

        formElement.submit = function (e) {
            e.preventDefault();
            var isFormValid = true;
            options.rules.forEach(function (rule) {
                // Loop through each rule and validate form
                var inputElement = formElement.querySelector(rule.selector);
                var isValid = validate(inputElement, rule);
                if (!isValid) {
                    isFormValid = false;
                }
            });
            if (isFormValid) {
                // Case submit with JS
                if (typeof options.onSubmit === "function") {
                    var enableInputs = formElement.querySelectorAll(
                        "[name]:not([disabled])"
                    );
                    var formValues = Array.from(enableInputs).reduce((values, input) => {
                        values[input.name] = input.value;
                        return values;
                    }, {});
                    options.onSubmit(formValues);
                }
                // Case submit with default options
                else {
                    formElement.submit();
                }
            }
        };
        // console.log(formElement);
        // loop through each role and handle it
        options.rules.forEach(function (rule) {
            // save each rule for each input
            if (Array.isArray(selectorRules[rule.selector])) {
                selectorRules[rule.selector].push(rule.test);
            } else {
                selectorRules[rule.selector] = [rule.test];
            }

            const inputElement = formElement.querySelector(rule.selector);
            if (inputElement) {
                inputElement.onblur = function () {
                    validate(inputElement, rule);
                }
                inputElement.oninput = function () {
                    console.log('oninput');
                }
            }

        })
    }
}

// Define rules
// rule : when have error =>  return error message
// rule : when not have error => return nothing (undefined)
validator.isRequired = function (selector, message) {
    return {
        selector: selector,
        test: function (value) {
            return value.trim("")
                ? undefined
                : message || `Please enter this field !!!`;
        },
    };
}
validator.isEmail = function (selector, message) {
    return {
        selector: selector,
        test: function (value, message) {
            var regrex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            return regrex.test(value)
                ? undefined
                : message || "Please enter right format email  !!!";
        },
    }
}
validator.minLength = function (selector, minLength, message) {
    return {
        selector: selector,
        test: function (value) {
            return value.length >= minLength
                ? undefined
                : message ||
                `Please enter password's length at least ${minLength} char`;
        },
    };
};

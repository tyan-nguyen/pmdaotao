/*!
 * Modal Remote
 * =================================
 *  * author aslinye cuma beliau masih bootstrap 3
 * Use for johnitvn/yii2-ajaxcrud extension
 * @author John Martin john.itvn@gmail.com
 */
(function ($) {
    $.fn.hasAttr = function (name) {
        return this.attr(name) !== undefined;
    };
}(jQuery));

function ModalRemote(modalId) {

    this.defaults = {
        okLabel: "OK",
        executeLabel: "Execute",
        cancelLabel: "Cancel",
        loadingTitle: "Loading"
    };

    this.modal = $(modalId);

    this.dialog = $(modalId).find('.modal-dialog');

    this.header = $(modalId).find('.modal-header');

    this.content = $(modalId).find('.modal-body');

    this.footer = $(modalId).find('.modal-footer');

    this.loadingContent =
        '<div class="progress">' +
        '<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>' +
        '</div>';

    let xhr;

    $(this.modal).on('hidden.bs.modal', function (e) {
        abortXHR(xhr);
    });

    /**
     * Show the modal
     */
    this.show = function () {
        this.clear();
        $(this.modal).modal('show');
    };

    /**
     * Hide the modal
     */
    this.hide = function () {
        $(this.modal).modal('hide');
    };

    /**
     * Toogle show/hide modal
     */
    this.toggle = function () {
        $(this.modal).modal('toggle');
    };

    /**
     * Clear modal
     */
    this.clear = function () {
        $(this.modal).find('.modal-title').remove();
        $(this.content).html("");
        $(this.footer).html("");
    };

    /**
     * Set size of modal
     * @param {string} size large/normal/small
     */
    this.setSize = function (size) {
        $(this.dialog).removeClass('modal-lg');
        $(this.dialog).removeClass('modal-sm');
        if (size == 'large')
            $(this.dialog).addClass('modal-lg');
        else if (size == 'small')
            $(this.dialog).addClass('modal-sm');
        else if (size !== 'normal')
            console.warn("Undefined size " + size);
    };

    /**
     * Set modal header
     * @param {string} content The content of modal header
     */
    this.setHeader = function (content) {
        $(this.header).html(content);
    };

    /**
     * Set modal content
     * @param {string} content The content of modal content
     */
    this.setContent = function (content) {
        $(this.content).html(content);
    };

    this.setFocusOnInput = function () {
        const $content = $(this.content);

        let targetEl;
        const $autofocusElements = $content.find('input[autofocus], textarea[autofocus]');
        if ($autofocusElements.length > 0) {
            targetEl = $autofocusElements.last()[0];
        } else {
            const $inputElements = $content.find('input, textarea');
            if ($inputElements.length > 0) {
                targetEl = $autofocusElements.first()[0];
            }
        }

        if (targetEl && document.activeElement !== targetEl) {
            try {
                document.activeElement.blur();
            } catch (e) { console.log(e); }

            // Chrome does not allow to focus input until it is rendered. MutationObserver does not help
            const intervalMs = 50;
            const maxAttempts = 40;
            let attempt = -1;
            function setFocus() {
                attempt++;
                if (document.activeElement === targetEl ||
                    attempt >= maxAttempts
                ) {
                    return;
                }

                targetEl.focus();
                setTimeout(setFocus, intervalMs);
            }
            setFocus();
        }
    }

    /**
     * Set modal footer
     * @param {string} content The content of modal footer
     */
    this.setFooter = function (content) {
		//content = content.replace('>Close<', '><span class="fe fe-x"></span> Đóng lại<');
		//content = content.replace('>Edit<', '><span class="ti-pencil-alt"></span> Sửa<');
		//content = content.replace('>Copy<', '><span class="fe fe-copy"></span> Nhân đôi<');
		content = content.replace('>Đóng lại<', '><span class="fe fe-x"></span> Đóng lại<');
		content = content.replace('>Đóng<', '><span class="fe fe-x"></span> Đóng lại<');
		content = content.replace('>Sửa<', '><span class="ti-pencil-alt"></span> Sửa<');
		content = content.replace('>Tiếp tục thêm<', '><span class="fe fe-plus"></span> Tiếp tục thêm<');
		content = content.replace('>Tìm thiết bị<', '><span class="fe fe-search"></span> Tìm thiết bị<');
		content = content.replace('>Tải lên<', '><span class="fe fe-upload"></span> Tải lên<');
		content = content.replace('>Tiến hành upload<', '><span class="fe fe-upload"></span> Tiến hành upload<');
		content = content.replace('>Lưu lại<', '><span class="fe fe-save"></span> Lưu lại<');
		content = content.replace('>Copy<', '><span class="fe fe-copy"></span> Nhân đôi<');
        $(this.footer).html(content);
    };

    /**
     * Set modal footer
     * @param {string} title The title of modal
     */
    this.setTitle = function (title) {
        // remove old title
        $(this.header).find('h5.modal-title').remove();
        // add new title
        $(this.header).prepend('<h5 class="modal-title text-primary">' + title + '</h5>');
    };

    /**
     * Hide close button
     */
    this.hidenCloseButton = function () {
        $(this.header).find('button.close').hide();
    };

    /**
     * Show close button
     */
    this.showCloseButton = function () {
        $(this.header).find('button.close').show();
    };

    /**
     * Show loading state in modal
     */
    this.displayLoading = function () {
        this.setContent(this.loadingContent);
        this.setTitle(this.defaults.loadingTitle);
    };

    /**
     * Add button to footer
     * @param string label The label of button
     * @param string classes The class of button
     * @param callable callback the callback when button click
     */
    this.addFooterButton = function (label, type, classes, callback) {
        buttonElm = document.createElement('button');
        buttonElm.setAttribute('type', type === null ? 'button' : type);
        buttonElm.setAttribute('class', classes === null ? 'btn btn-primary' : classes);
        if(label == 'Đóng lại'){
			buttonElm.innerHTML = '<span class="fe fe-x"></span> ' + label;
		} else {
			buttonElm.innerHTML = label;
		}
        var instance = this;
        $(this.footer).append(buttonElm);
        if (callback !== null) {
            $(buttonElm).click(function (event) {
                callback.call(instance, this, event);
            });
        }
    };

    /**
     * Send ajax request and wraper response to modal
     * @param {string} url The url of request
     * @param {string} method The method of request
     * @param {object}data of request
     */
    this.doRemote = function (url, method, data) {
        var instance = this;
        abortXHR(xhr);
        xhr = $.ajax({
            url: url,
            method: method,
            data: data,
            beforeSend: function () {
                beforeRemoteRequest.call(instance);
            },
            error: function (response) {
                errorRemoteResponse.call(instance, response);
            },
            success: function (response) {
                successRemoteResponse.call(instance, response);
            },
            contentType: false,
            cache: false,
            processData: false
        });
    };

    /**
     * Before send request process
     * - Ensure clear and show modal
     * - Show loading state in modal
     */
    function beforeRemoteRequest() {
        this.show();
        this.displayLoading();
    }


    /**
     * When remote sends error response
     * @param {string} response
     */
    function errorRemoteResponse(response) {
        this.setTitle(response.status + response.statusText);
        this.setContent(response.responseText);
        this.addFooterButton('Close', 'button', 'btn btn-default', function (button, event) {
            this.hide();
        })
    }

    /**
     * When remote sends success response
     * @param {string} response
     */
    function successRemoteResponse(response) {

        // Reload datatable if response contain forceReload field
        if (response.forceReload !== undefined && response.forceReload) {
            if (response.forceReload == 'true') {
                // Backwards compatible reload of fixed crud-datatable-pjax
                $.pjax.reload({ container: '#crud-datatable-pjax' });
            } else {
                $.pjax.reload({ container: response.forceReload });
            }            
        }
        
        /* send notify */
		if(typeof response.tcontent !== 'undefined'){
			showNotif(response.tcontent);
		}
			
		 //***reload block reloadType !== 'undefined'){
         if(typeof response.reloadType !== 'undefined'){
            $(response.reloadBlock).html(response.reloadContent);
		}
		
		if(response.runFunc == true){
			if(response.runFuncVal1 != undefined && response.runFuncVal2 != undefined){
				runFunc(response.runFuncVal1, response.runFuncVal2);
			} else if(response.runFuncVal1 != undefined && response.runFuncVal2 == undefined){
				runFunc(response.runFuncVal1);
			} else {
				runFunc();
			}
			//return;
		}
        
		/** process excute function after forceReload */
		// Close modal if response contains forceClose field
       /* if (response.excuteFunction !== undefined && response.excuteFunction) {
            funcOne(response.functionResponse);
        }
        if (response.excuteFunction2 !== undefined && response.excuteFunction2) {
            funcGv(response.functionResponse2);
        }
      */
       // if (response.excuteFunctionDay !== undefined && response.excuteFunctionDay) {
         //   funcUploadDay(response.functionResponseDay);
      //  }
        // Close modal if response contains forceClose field
        if (response.forceClose !== undefined && response.forceClose) {
            this.hide();
            return;
        }

        if (response.size !== undefined)
            this.setSize(response.size);

        if (response.title !== undefined)
            this.setTitle(response.title);

        if (response.content !== undefined) {
            this.setContent(response.content);
            this.setFocusOnInput();
        }

        if (response.footer !== undefined)
            this.setFooter(response.footer);

        if ($(this.content).find("form")[0] !== undefined) {
            this.setupFormSubmit(
                $(this.content).find("form")[0],
                $(this.footer).find('[type="submit"]')[0]
            );
        }
    }

    /**
     * Prepare submit button when modal has form
     * @param {string} modalForm
     * @param {object} modalFormSubmitBtn
     */
    this.setupFormSubmit = function (modalForm, modalFormSubmitBtn) {
        if (modalFormSubmitBtn === undefined) {
            // If submit button not found throw warning message
            console.warn('Modal has form but does not have a submit button');
        } else {
            var instance = this;

            // Submit form when user clicks submit button
            $(modalFormSubmitBtn).click(function (e) {
                var data;

                // Test if browser supports FormData which handles uploads
                if (window.FormData) {
                    data = new FormData($(modalForm)[0]);
                    //***gui trang thai luu tam
                    if($(modalFormSubmitBtn).attr('value')=='luuTam'){
                    	data.append("submitType", $(modalFormSubmitBtn).attr('value'));
                    }
                } else {
                    // Fallback to serialize
                    data = $(modalForm).serializeArray();
                }

                instance.doRemote(
                    $(modalForm).attr('action'),
                    $(modalForm).hasAttr('method') ? $(modalForm).attr('method') : 'GET',
                    data
                );
            });
        }
    };

    /**
     * Show the confirm dialog
     * @param {string} title The title of modal
     * @param {string} message The message for ask user
     * @param {string} okLabel The label of ok button
     * @param {string} cancelLabel The class of cancel button
     * @param {string} size The size of the modal
     * @param {string} dataUrl Where to post
     * @param {string} dataRequestMethod POST or GET
     * @param {number[]} selectedIds
     */
    this.confirmModal = function (title, message, okLabel, cancelLabel, size, dataUrl, dataRequestMethod, selectedIds) {
        this.show();
        this.setSize(size);

        if (title !== undefined) {
            this.setTitle(title);
        }
        // Add form for user input if required
        this.setContent('<form id="ModalRemoteConfirmForm">' + message);

        var instance = this;
        if (okLabel !== false) {
            this.addFooterButton(
                okLabel === undefined ? this.defaults.okLabel : okLabel,
                'submit',
                'btn btn-primary',
                function (e) {
                    var data;

                    // Test if browser supports FormData which handles uploads
                    if (window.FormData) {
                        data = new FormData($('#ModalRemoteConfirmForm')[0]);
                        if (typeof selectedIds !== 'undefined' && selectedIds)
                            data.append('pks', selectedIds.join());
                    } else {
                        // Fallback to serialize
                        data = $('#ModalRemoteConfirmForm');
                        if (typeof selectedIds !== 'undefined' && selectedIds)
                            data.pks = selectedIds;
                        data = data.serializeArray();
                    }

                    instance.doRemote(
                        dataUrl,
                        dataRequestMethod,
                        data
                    );
                }
            );
        }

        this.addFooterButton(
            cancelLabel === undefined ? this.defaults.cancelLabel : cancelLabel,
            'button',
            'btn btn-default pull-left',
            function (e) {
                this.hide();
            }
        );

    }

    /**
     * Open the modal
     * HTML data attributes for use in local confirm
     *   - href/data-url         (If href not set will get data-url)
     *   - data-request-method   (string GET/POST)
     *   - data-confirm-ok       (string OK button text)
     *   - data-confirm-cancel   (string cancel button text)
     *   - data-confirm-title    (string title of modal box)
     *   - data-confirm-message  (string message in modal box)
     *   - data-modal-size       (string small/normal/large)
     * Attributes for remote response (json)
     *   - forceReload           (string reloads a pjax ID)
     *   - forceClose            (boolean remote close modal)
     *   - size                  (string small/normal/large)
     *   - title                 (string/html title of modal box)
     *   - content               (string/html content in modal box)
     *   - footer                (string/html footer of modal box)
     * @params {elm}
     */
    this.open = function (elm, bulkData) {
        /**
         * Show either a local confirm modal or get modal content through ajax
         */
        if ($(elm).hasAttr('data-confirm-title') || $(elm).hasAttr('data-confirm-message')) {
            this.confirmModal(
                $(elm).attr('data-confirm-title'),
                $(elm).attr('data-confirm-message'),
                $(elm).attr('data-confirm-alert') ? false : $(elm).attr('data-confirm-ok'),
                $(elm).attr('data-confirm-cancel'),
                $(elm).hasAttr('data-modal-size') ? $(elm).attr('data-modal-size') : 'normal',
                $(elm).hasAttr('href') ? $(elm).attr('href') : $(elm).attr('data-url'),
                $(elm).hasAttr('data-request-method') ? $(elm).attr('data-request-method') : 'GET',
                bulkData
            )
        } else {
            this.doRemote(
                $(elm).hasAttr('href') ? $(elm).attr('href') : $(elm).attr('data-url'),
                $(elm).hasAttr('data-request-method') ? $(elm).attr('data-request-method') : 'GET',
                bulkData
            );
        }
    };

    function abortXHR(xhr) {
        if (xhr && xhr.readyState < 4) {
            xhr.onreadystatechange = $.noop;
            xhr.abort();
        }
    }
} // End of Object

<section class="views-tabs">
    <input id="pledge" name="main-tabs" checked="" type="radio">
    <input id="refund" name="main-tabs" type="radio">
    <input id="pay" name="main-tabs" type="radio">
    <input id="other" name="main-tabs" type="radio">

    <ul class="templates-menu">
        <li class="custom-tooltip">
            <label for="pledge" class="tab-name">
                <i class="mdi mdi-library"></i>
                <span>Pledge</span>
            </label>
            <div class="tooltip">
                <div class="tooltip__background"></div>
                <span class="tooltip__label">Pledge Template</span>
            </div>
        </li>
        <li class="custom-tooltip">
            <label for="pay" class="tab-name">
                <i class="mdi mdi-credit-card"></i>
                <span>Pay</span>
            </label>
            <div class="tooltip">
                <div class="tooltip__background"></div>
                <span class="tooltip__label">Pay Template</span>
            </div>
        </li>
        <li class="custom-tooltip">
            <label for="refund" class="tab-name">
                <i class="mdi mdi-backup-restore"></i>
                <span>Refund</span>
            </label>
            <div class="tooltip">
                <div class="tooltip__background"></div>
                <span class="tooltip__label">Refund Template</span>
            </div>
        </li>
        <li class="custom-tooltip">
            <label for="other" class="tab-name">
                <i class="mdi mdi-note-plus"></i>
                <span>Other</span>
            </label>
            <div class="tooltip">
                <div class="tooltip__background"></div>
                <span class="tooltip__label">Other Templates</span>
            </div>
        </li>
    </ul>

    <div class="templates-views pledge" data-template="pledge" data-template2="auth">
        <div class="template-view">
            <div class="header-view">pledge template
            </div>
            <div class="content-view clearfix">
                <div class="flex-container">
                    <div class="flex-item-6 modal-shown no-transition" >
                        <div class="template-name" data-view-text="expanded">
                            Expanded view
                        </div>
                        <div id="render-pledge-expanded" class="modal-shown no-transition" data-view="expanded"></div>
                        <div class="template-name" data-view-text="collapsed">
                            Collapsed view
                        </div>
                        <div id="render-pledge-collapsed" data-view="collapsed"></div>
                    </div>
                    <div class="flex-item-6">
                        <section class="config-tabs">
                            <input id="pledge-ext-salutation" name="pledge-ext" checked=""
                                   type="radio">
                            <label for="pledge-ext-salutation" class="tab-name">
                                Salutation
                            </label>
                            <div class="tab-content" data-template="salutation">
                                <div class="custom-label" data-template="expanded">
                                    <div class="custom-tooltip">
                                        <label>Salutation <span class="fa fa-question-circle-o"></span>
                                            <div class="tooltip">
                                                <div class="tooltip__background"></div>
                                                <span class="tooltip__label" data-var="pledge-welcome"></span>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="custom-input">
                                        <input type="text" name="welcome" value="Dear {user}," placeholder="Dear {user}," required="" />
                                        <span class="bar"></span>
                                    </div>
                                </div>

                                <div class="flex-container flex-gutter" data-template="style">
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Color</label>
                                            <div class="custom-input">
                                                <input type="color" data-template-css="color" placeholder="#404040" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Font Size</label>
                                            <div class="custom-input">
                                                <input type="text" data-template-css="font-size" placeholder="13px" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Font Weight</label>
                                            <div class="form-select">
                                                <select data-template-css="font-weight">
                                                    <option selected>normal</option>
                                                    <option>bold</option>
                                                    <option>bolder</option>
                                                    <option>lighter</option>
                                                    <option>100</option>
                                                    <option>200</option>
                                                    <option>300</option>
                                                    <option>400</option>
                                                    <option>500</option>
                                                    <option>600</option>
                                                    <option>700</option>
                                                    <option>800</option>
                                                    <option>900</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-container flex-gutter" data-template="style">
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Font Style</label>
                                            <div class="form-select">
                                                <select data-template-css="font-style">
                                                    <option selected>normal</option>
                                                    <option>italic</option>
                                                    <option>oblique</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Text Align</label>
                                            <div class="form-select">
                                                <select data-template-css="text-align">
                                                    <option selected>left</option>
                                                    <option>right</option>
                                                    <option>center</option>
                                                    <option>justify</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Text Transform</label>
                                            <div class="form-select">
                                                <select data-template-css="text-transform">
                                                    <option selected>none</option>
                                                    <option>capitalize</option>
                                                    <option>uppercase</option>
                                                    <option>lowercase</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <input id="pledge-ext-message" value="card" name="pledge-ext"
                                   type="radio">
                            <label for="pledge-ext-message" class="tab-name">
                                Message
                            </label>
                            <div class="tab-content" data-template="message">
                                <div class="custom-label" data-template="expanded">
                                    <div class="custom-tooltip">
                                        <label>Message (Expanded View) <span class="fa fa-question-circle-o"></span>
                                            <div class="tooltip">
                                                <div class="tooltip__background"></div>
                                                <span class="tooltip__label" data-var="pledge-message-expanded"></span>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="custom-input">
                                        <input type="text" name="message-expanded" value="Please support quality journalism. Would you pledge to pay a small fee of {price} to continue reading?" placeholder="Please support quality journalism. Would you pledge to pay a small fee of {price} to continue reading?" required="" />
                                        <span class="bar"></span>
                                    </div>
                                </div>
                                <div class="custom-label" data-template="collapsed">
                                    <div class="custom-tooltip">
                                        <label>Message (Collapsed View) <span class="fa fa-question-circle-o"></span>
                                            <div class="tooltip">
                                                <div class="tooltip__background"></div>
                                                <span class="tooltip__label" data-var="pledge-message-collapsed"></span>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="custom-input">
                                        <input type="text" name="message-collapsed" value="Please support quality journalism. {pledge-button}" placeholder="Please support quality journalism." required="" />
                                        <span class="bar"></span>
                                    </div>
                                </div>
                                <div class="flex-container flex-gutter" data-template="style">
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Color</label>
                                            <div class="custom-input">
                                                <input type="color" data-template-css="color" placeholder="#404040" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Font Size</label>
                                            <div class="custom-input">
                                                <input type="text" data-template-css="font-size" placeholder="13px" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Font Weight</label>
                                            <div class="form-select">
                                                <select data-template-css="font-weight">
                                                    <option selected>normal</option>
                                                    <option>bold</option>
                                                    <option>bolder</option>
                                                    <option>lighter</option>
                                                    <option>100</option>
                                                    <option>200</option>
                                                    <option>300</option>
                                                    <option>400</option>
                                                    <option>500</option>
                                                    <option>600</option>
                                                    <option>700</option>
                                                    <option>800</option>
                                                    <option>900</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-container flex-gutter" data-template="style">
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Font Style</label>
                                            <div class="form-select">
                                                <select data-template-css="font-style">
                                                    <option selected>normal</option>
                                                    <option>italic</option>
                                                    <option>oblique</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Text Align</label>
                                            <div class="form-select">
                                                <select data-template-css="text-align">
                                                    <option selected>left</option>
                                                    <option>right</option>
                                                    <option>center</option>
                                                    <option>justify</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Text Transform</label>
                                            <div class="form-select">
                                                <select data-template-css="text-transform">
                                                    <option selected>none</option>
                                                    <option>capitalize</option>
                                                    <option>uppercase</option>
                                                    <option>lowercase</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <input id="pledge-ext-user" value="card" name="pledge-ext" type="radio">
                            <label for="pledge-ext-user" class="tab-name">
                                User
                            </label>
                            <div class="tab-content" data-template="user">
                                <div class="custom-label" data-template="expanded">
                                    <div class="custom-tooltip">
                                        <label>Connect Message <span class="fa fa-question-circle-o" aria-hidden="true"></span>
                                            <div class="tooltip">
                                                <div class="tooltip__background"></div>
                                                <span class="tooltip__label" data-var="pledge-user-used"></span>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="custom-input">
                                        <input type="text" name="user-used" value="Already used us before? {connect-link}" placeholder="Already used us before? {connect-link}" required="" />
                                        <span class="bar"></span>
                                    </div>
                                </div>

                                <div class="custom-label" data-template="expanded">
                                    <div class="custom-tooltip">
                                        <label>Disconnect Message <span class="fa fa-question-circle-o" aria-hidden="true"></span>
                                            <div class="tooltip">
                                                <div class="tooltip__background"></div>
                                                <span class="tooltip__label" data-var="pledge-user-logged"></span>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="custom-input">
                                        <input type="text"  name="user-logged"  value="Not {user}? {disconnect-link}" placeholder="Not {user}? {disconnect-link}" required="" />
                                        <span class="bar"></span>
                                    </div>
                                </div>

                                <div class="flex-container flex-gutter" data-template="style">
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Color</label>
                                            <div class="custom-input">
                                                <input type="color" data-template-css="color" placeholder="#404040" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Font Size</label>
                                            <div class="custom-input">
                                                <input type="text" data-template-css="font-size" value="12px" placeholder="12px" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Font Weight</label>
                                            <div class="form-select">
                                                <select data-template-css="font-weight" >
                                                    <option selected>normal</option>
                                                    <option>bold</option>
                                                    <option>bolder</option>
                                                    <option>lighter</option>
                                                    <option>100</option>
                                                    <option>200</option>
                                                    <option>300</option>
                                                    <option>400</option>
                                                    <option>500</option>
                                                    <option>600</option>
                                                    <option>700</option>
                                                    <option>800</option>
                                                    <option>900</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-container flex-gutter" data-template="style">
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Font Style</label>
                                            <div class="form-select">
                                                <select data-template-css="font-style">
                                                    <option selected>normal</option>
                                                    <option>italic</option>
                                                    <option>oblique</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Text Align</label>
                                            <div class="form-select">
                                                <select data-template-css="text-align">
                                                    <option selected>left</option>
                                                    <option>right</option>
                                                    <option>center</option>
                                                    <option>justify</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Text Transform</label>
                                            <div class="form-select">
                                                <select data-template-css="text-transform">
                                                    <option selected>none</option>
                                                    <option>capitalize</option>
                                                    <option>uppercase</option>
                                                    <option>lowercase</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <input id="pledge-ext-button" value="card" name="pledge-ext"
                                   type="radio">
                            <label for="pledge-ext-button" class="tab-name">
                                Button
                            </label>
                            <div class="tab-content">
                                <div class="flex-container flex-gutter">
                                    <div class="flex-item-6">
                                        <div class="custom-label">
                                            <label>Micropayments Button Text</label>
                                            <div class="custom-input">
                                                <input type="text" value="PLEDGE {price}" placeholder="PLEDGE {price}" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-6">
                                        <div class="custom-label">
                                            <label>Micropayments Button Icon</label>
                                            <div class="custom-input">
                                                <input type="text" placeholder="fa-check" value="fa-check" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-container flex-gutter">
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Background Color</label>
                                            <div class="custom-input">
                                                <input type="color" placeholder="#1b93f2" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Border</label>
                                            <div class="custom-input">
                                                <input type="text" placeholder="1px solid #1b93f2" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Font Size</label>
                                            <div class="custom-input">
                                                <input type="text" placeholder="11px" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-container flex-gutter">
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Font Weight</label>
                                            <div class="form-select">
                                                <select data-template-css="font-weight">
                                                    <option selected>normal</option>
                                                    <option>bold</option>
                                                    <option>bolder</option>
                                                    <option>lighter</option>
                                                    <option>100</option>
                                                    <option>200</option>
                                                    <option>300</option>
                                                    <option>400</option>
                                                    <option>500</option>
                                                    <option>600</option>
                                                    <option>700</option>
                                                    <option>800</option>
                                                    <option>900</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Border Radius</label>
                                            <div class="custom-input">
                                                <input type="text" placeholder="2px" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Color</label>
                                            <div class="custom-input">
                                                <input type="color" placeholder="#ffffff" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-container flex-gutter">
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Font Style</label>
                                            <div class="form-select">
                                                <select data-template-css="font-style">
                                                    <option selected>normal</option>
                                                    <option>italic</option>
                                                    <option>oblique</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Text Align</label>
                                            <div class="form-select">
                                                <select data-template-css="text-align">
                                                    <option selected>left</option>
                                                    <option>right</option>
                                                    <option>center</option>
                                                    <option>justify</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Text Transform</label>
                                            <div class="form-select">
                                                <select data-template-css="text-transform">
                                                    <option selected>none</option>
                                                    <option>capitalize</option>
                                                    <option>uppercase</option>
                                                    <option>lowercase</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <input id="pledge-ext-arrow" value="card" name="pledge-ext"
                                   type="radio">
                            <label for="pledge-ext-arrow" class="tab-name">
                                Arrow
                            </label>
                            <div class="tab-content">
                                <div class="flex-container flex-gutter">
                                    <div class="flex-item-6">
                                        <div class="custom-label">
                                            <label>Closing Arrow</label>
                                            <div class="custom-input">
                                                <input type="text" placeholder="fa-chevron-circle-up" value="fa-chevron-circle-up" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-6">
                                        <div class="custom-label">
                                            <label>Color</label>
                                            <div class="custom-input">
                                                <input type="color" value="#404040" placeholder="#404040" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-container flex-gutter">
                                    <div class="flex-item-6">
                                        <div class="custom-label">
                                            <label>Opening Arrow</label>
                                            <div class="custom-input">
                                                <input type="text" placeholder="fa-chevron-circle-down" value="fa-chevron-circle-down" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-6">
                                        <div class="custom-label">
                                            <label>Color</label>
                                            <div class="custom-input">
                                                <input type="color" value="#404040" placeholder="#404040" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </section>
                    </div>
                </div>
                <div class="custom-input pull-right">
                    <button type="button" class="btn save-templates"><i
                            class="mdi mdi-check"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="templates-views pay" data-template="pay">
        <div class="template-view">
            <div class="header-view">pay template</div>
            <div class="content-view clearfix">
                <div class="flex-container">
                    <div class="flex-item-6">
                        <div class="template-name" data-view-text="expanded">
                            Expanded view
                        </div>
                        <div id="render-pay-expanded" data-view="expanded" ></div>

                        <div class="template-name" data-view-text="collapsed">
                            Collapsed view
                        </div>
                        <div id="render-pay-collapsed" data-view="collapsed"></div>
                    </div>
                    <div class="flex-item-6">
                        <section class="config-tabs">
                            <input id="pay-ext-salutation" name="pay-ext" checked="" type="radio">
                            <label for="pay-ext-salutation" class="tab-name">
                                Salutation
                            </label>
                            <div class="tab-content" data-template="salutation">
                                <div class="custom-label" data-template="expanded">
                                    <div class="custom-tooltip">
                                        <label>Salutation <span class="fa fa-question-circle-o" aria-hidden="true"></span>
                                            <div class="tooltip">
                                                <div class="tooltip__background"></div>
                                                <span class="tooltip__label" data-var="pay-salutation"></span>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="custom-input">
                                        <input type="text" name="salutation" value="Dear {user}," placeholder="Dear {user}," required="" />
                                        <span class="bar"></span>
                                    </div>
                                </div>

                                <div class="flex-container flex-gutter" data-template="style">
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Color</label>
                                            <div class="custom-input">
                                                <input type="color" data-template-css="color" placeholder="#404040" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Font Size</label>
                                            <div class="custom-input">
                                                <input type="text" data-template-css="font-size" placeholder="13px" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Font Weight</label>
                                            <div class="form-select">
                                                <select data-template-css="font-weight">
                                                    <option selected>normal</option>
                                                    <option>bold</option>
                                                    <option>bolder</option>
                                                    <option>lighter</option>
                                                    <option>100</option>
                                                    <option>200</option>
                                                    <option>300</option>
                                                    <option>400</option>
                                                    <option>500</option>
                                                    <option>600</option>
                                                    <option>700</option>
                                                    <option>800</option>
                                                    <option>900</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-container flex-gutter" data-template="style">
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Font Style</label>
                                            <div class="form-select">
                                                <select data-template-css="font-style">
                                                    <option selected>normal</option>
                                                    <option>italic</option>
                                                    <option>oblique</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Text Align</label>
                                            <div class="form-select">
                                                <select data-template-css="text-align">
                                                    <option selected>left</option>
                                                    <option>right</option>
                                                    <option>center</option>
                                                    <option>justify</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Text Transform</label>
                                            <div class="form-select">
                                                <select data-template-css="text-transform">
                                                    <option selected>none</option>
                                                    <option>capitalize</option>
                                                    <option>uppercase</option>
                                                    <option>lowercase</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <input id="pay-ext-message" name="pay-ext" type="radio">
                            <label for="pay-ext-message" class="tab-name">
                                Message
                            </label>
                            <div class="tab-content" data-template="message">
                                <div class="custom-label" data-template="expanded">
                                    <div class="custom-tooltip">
                                        <label>Message (Expanded View) <span class="fa fa-question-circle-o" aria-hidden="true"></span>
                                            <div class="tooltip">
                                                <div class="tooltip__background"></div>
                                                <span class="tooltip__label" data-var="pay-message-expanded"></span>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="custom-input">
                                        <input type="text" name="message-expanded" value="Please support quality journalism. Would you pledge to pay a small fee of {price} to continue reading?" placeholder="Please support quality journalism. Would you pledge to pay a small fee of {price} to continue reading?" required="" />
                                        <span class="bar"></span>
                                    </div>
                                </div>

                                <div class="custom-label" data-template="collapsed">
                                    <div class="custom-tooltip">
                                        <label>Message (Collapsed View) <span class="fa fa-question-circle-o" aria-hidden="true"></span>
                                            <div class="tooltip">
                                                <div class="tooltip__background"></div>
                                                <span class="tooltip__label" data-var="pay-message-collapsed"></span>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="custom-input">
                                        <input type="text" name="message-collapsed" value="Support quality journalism. {pay-button} " placeholder="Support quality journalism. {pay-button} " required="" />
                                        <span class="bar"></span>
                                    </div>
                                </div>

                                <div class="flex-container flex-gutter" data-template="style">
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Color</label>
                                            <div class="custom-input">
                                                <input type="color" data-template-css="color" placeholder="#404040" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Font Size</label>
                                            <div class="custom-input">
                                                <input type="text" data-template-css="font-size" placeholder="13px" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Font Weight</label>
                                            <div class="form-select">
                                                <select data-template-css="font-weight">
                                                    <option selected>normal</option>
                                                    <option>bold</option>
                                                    <option>bolder</option>
                                                    <option>lighter</option>
                                                    <option>100</option>
                                                    <option>200</option>
                                                    <option>300</option>
                                                    <option>400</option>
                                                    <option>500</option>
                                                    <option>600</option>
                                                    <option>700</option>
                                                    <option>800</option>
                                                    <option>900</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-container flex-gutter" data-template="style">
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Font Style</label>
                                            <div class="form-select">
                                                <select data-template-css="font-style">
                                                    <option selected>normal</option>
                                                    <option>italic</option>
                                                    <option>oblique</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Text Align</label>
                                            <div class="form-select">
                                                <select data-template-css="text-align">
                                                    <option selected>left</option>
                                                    <option>right</option>
                                                    <option>center</option>
                                                    <option>justify</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Text Transform</label>
                                            <div class="form-select">
                                                <select data-template-css="text-transform">
                                                    <option selected>none</option>
                                                    <option>capitalize</option>
                                                    <option>uppercase</option>
                                                    <option>lowercase</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <input id="pay-ext-user" name="pay-ext" type="radio">
                            <label for="pay-ext-user" class="tab-name">
                                User
                            </label>
                            <div class="tab-content" data-template="user">
                                <div class="custom-label" data-template="expanded">
                                    <div class="custom-tooltip">
                                        <label>Connect Message <span class="fa fa-question-circle-o" aria-hidden="true"></span>
                                            <div class="tooltip">
                                                <div class="tooltip__background"></div>
                                                <span class="tooltip__label" data-var="pay-user-used"></span>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="custom-input">
                                        <input type="text" name="user-used" value="Already used us before? {connect-link}" placeholder="Already used us before? {connect-link}" required="" />
                                        <span class="bar"></span>
                                    </div>
                                </div>

                                <div class="custom-label" data-template="expanded">
                                    <div class="custom-tooltip">
                                        <label>Disconnect Message <span class="fa fa-question-circle-o" aria-hidden="true"></span>
                                            <div class="tooltip">
                                                <div class="tooltip__background"></div>
                                                <span class="tooltip__label" data-var="pay-user-logged"></span>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="custom-input">
                                        <input type="text"  name="user-logged"  value="Not {user}? {disconnect-link}" placeholder="Not {user}? {disconnect-link}" required="" />
                                        <span class="bar"></span>
                                    </div>
                                </div>

                                <div class="flex-container flex-gutter" data-template="style">
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Color</label>
                                            <div class="custom-input">
                                                <input type="color" data-template-css="color" placeholder="#404040" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Font Size</label>
                                            <div class="custom-input">
                                                <input type="text" data-template-css="font-size" value="12px" placeholder="12px" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Font Weight</label>
                                            <div class="form-select">
                                                <select data-template-css="font-weight" >
                                                    <option selected>normal</option>
                                                    <option>bold</option>
                                                    <option>bolder</option>
                                                    <option>lighter</option>
                                                    <option>100</option>
                                                    <option>200</option>
                                                    <option>300</option>
                                                    <option>400</option>
                                                    <option>500</option>
                                                    <option>600</option>
                                                    <option>700</option>
                                                    <option>800</option>
                                                    <option>900</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-container flex-gutter" data-template="style">
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Font Style</label>
                                            <div class="form-select">
                                                <select data-template-css="font-style">
                                                    <option selected>normal</option>
                                                    <option>italic</option>
                                                    <option>oblique</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Text Align</label>
                                            <div class="form-select">
                                                <select data-template-css="text-align">
                                                    <option selected>left</option>
                                                    <option>right</option>
                                                    <option>center</option>
                                                    <option>justify</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Text Transform</label>
                                            <div class="form-select">
                                                <select data-template-css="text-transform">
                                                    <option selected>none</option>
                                                    <option>capitalize</option>
                                                    <option>uppercase</option>
                                                    <option>lowercase</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <input id="pay-ext-input" name="pay-ext" type="radio">
                            <label for="pay-ext-input" class="tab-name">
                                Input
                            </label>
                            <div class="tab-content">
                                <div class="flex-container flex-gutter">
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Background Color</label>
                                            <div class="custom-input">
                                                <input type="color" placeholder="#ffffff" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Border</label>
                                            <div class="custom-input">
                                                <input type="text" placeholder="1px solid #e2e2e2" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Border Radius</label>
                                            <div class="custom-input">
                                                <input type="text" placeholder="3px" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-container flex-gutter">
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Font Size</label>
                                            <div class="custom-input">
                                                <input type="text" placeholder="13px" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Font Weight</label>
                                            <div class="form-select">
                                                <select data-template-css="font-weight">
                                                    <option selected>normal</option>
                                                    <option>bold</option>
                                                    <option>bolder</option>
                                                    <option>lighter</option>
                                                    <option>100</option>
                                                    <option>200</option>
                                                    <option>300</option>
                                                    <option>400</option>
                                                    <option>500</option>
                                                    <option>600</option>
                                                    <option>700</option>
                                                    <option>800</option>
                                                    <option>900</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Color</label>
                                            <div class="custom-input">
                                                <input type="color" placeholder="#404040" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-container flex-gutter">
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Box Shadow</label>
                                            <div class="custom-input">
                                                <input type="text" placeholder="inset 2px 3px 3px rgba(0, 0, 0, 0.07)" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Text Transform</label>
                                            <div class="form-select">
                                                <select data-template-css="text-transform">
                                                    <option selected>none</option>
                                                    <option>capitalize</option>
                                                    <option>uppercase</option>
                                                    <option>lowercase</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Text Align</label>
                                            <div class="form-select">
                                                <select data-template-css="text-align">
                                                    <option selected>left</option>
                                                    <option>right</option>
                                                    <option>center</option>
                                                    <option>justify</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <input id="pay-ext-button" name="pay-ext" type="radio">
                            <label for="pay-ext-button" class="tab-name">
                                Button
                            </label>
                            <div class="tab-content">
                                <div class="flex-container flex-gutter">
                                    <div class="flex-item-6">
                                        <div class="custom-label">
                                            <label>Pay Button Text</label>
                                            <div class="custom-input">
                                                <input type="text" value="PAY" placeholder="PAY" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-6">
                                        <div class="custom-label">
                                            <label>Pay Button Icon</label>
                                            <div class="custom-input">
                                                <input type="text" value="fa-check" placeholder="fa-check" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-container flex-gutter">
                                    <div class="flex-item-6">
                                        <div class="custom-label">
                                            <label>Setup Button Text</label>
                                            <div class="custom-input">
                                                <input type="text" value="SETUP" placeholder="SETUP" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-6">
                                        <div class="custom-label">
                                            <label>Setup Button Icon</label>
                                            <div class="custom-input">
                                                <input type="text" value="fa-cog" placeholder="fa-cog" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-container flex-gutter">
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Background Color</label>
                                            <div class="custom-input">
                                                <input type="color" placeholder="#1b93f2" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Border</label>
                                            <div class="custom-input">
                                                <input type="text" placeholder="1px solid #1b93f2" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Font Size</label>
                                            <div class="custom-input">
                                                <input type="text" placeholder="11px" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-container flex-gutter">
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Font Weight</label>
                                            <div class="form-select">
                                                <select data-template-css="font-weight">
                                                    <option selected>normal</option>
                                                    <option>bold</option>
                                                    <option>bolder</option>
                                                    <option>lighter</option>
                                                    <option>100</option>
                                                    <option>200</option>
                                                    <option>300</option>
                                                    <option>400</option>
                                                    <option>500</option>
                                                    <option>600</option>
                                                    <option>700</option>
                                                    <option>800</option>
                                                    <option>900</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Border Radius</label>
                                            <div class="custom-input">
                                                <input type="text" placeholder="2px" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Color</label>
                                            <div class="custom-input">
                                                <input type="color" placeholder="#ffffff" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-container flex-gutter">
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Font Style</label>
                                            <div class="form-select">
                                                <select data-template-css="font-style">
                                                    <option selected>normal</option>
                                                    <option>italic</option>
                                                    <option>oblique</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Text Align</label>
                                            <div class="form-select">
                                                <select data-template-css="text-align">
                                                    <option selected>left</option>
                                                    <option>right</option>
                                                    <option>center</option>
                                                    <option>justify</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Text Transform</label>
                                            <div class="form-select">
                                                <select data-template-css="text-transform">
                                                    <option selected>none</option>
                                                    <option>capitalize</option>
                                                    <option>uppercase</option>
                                                    <option>lowercase</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <input id="pay-ext-arrow" name="pay-ext" type="radio">
                            <label for="pay-ext-arrow" class="tab-name">
                                Arrow
                            </label>
                            <div class="tab-content">
                                <div class="flex-container flex-gutter">
                                    <div class="flex-item-6">
                                        <div class="custom-label">
                                            <label>Closing Arrow</label>
                                            <div class="custom-input">
                                                <input type="text" value="fa-chevron-circle-up" placeholder="fa-chevron-circle-up" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-6">
                                        <div class="custom-label">
                                            <label>Color</label>
                                            <div class="custom-input">
                                                <input type="color" value="#404040" placeholder="#404040" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-container flex-gutter">
                                    <div class="flex-item-6">
                                        <div class="custom-label">
                                            <label>Opening Arrow</label>
                                            <div class="custom-input">
                                                <input type="text" value="fa-chevron-circle-down" placeholder="fa-chevron-circle-down" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-6">
                                        <div class="custom-label">
                                            <label>Color</label>
                                            <div class="custom-input">
                                                <input type="color" value="#404040" placeholder="#404040" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </section>
                    </div>
                </div>
                <div class="custom-input pull-right">
                    <button type="button" class="btn save-templates"><i class="mdi mdi-check"></i> Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="templates-views refund" data-template="refund">
        <div class="template-view">
            <div class="header-view">refund template</div>
            <div class="content-view clearfix">
                <div class="flex-container">
                    <div class="flex-item-6">
                        <div class="template-name" data-view-text="expanded">
                            Expanded view
                        </div>
                        <div id="render-refund-expanded"  data-view="expanded"></div>

                        <div class="template-name" data-view-text="collapsed">
                            Collapsed view
                        </div>
                        <div id="render-refund-collapsed" data-view="collapsed"></div>
                    </div>
                    <div class="flex-item-6">
                        <section class="config-tabs">
                            <input id="refund-ext-message" name="refund-ext" checked=""
                                   type="radio">
                            <label for="refund-ext-message" class="tab-name">
                                Message
                            </label>
                            <div class="tab-content" data-template="message">
                                <div class="custom-label" data-template="expanded">
                                    <div class="custom-tooltip">
                                        <label>Message (Expanded View) <span class="fa fa-question-circle-o" aria-hidden="true"></span>
                                            <div class="tooltip">
                                                <div class="tooltip__background"></div>
                                                <span class="tooltip__label" data-var="refund-message-expanded"></span>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="custom-input">
                                        <input type="text" name="message-expanded" value="Thanks for contributing {price} and help us do the job we {heart}" placeholder="Thanks for contributing {price} and help us do the job we {heart}" required="" />
                                        <span class="bar"></span>
                                    </div>
                                </div>

                                <div class="custom-label" data-template="collapsed">
                                    <div class="custom-tooltip">
                                        <label>Message (Collapsed View) <span class="fa fa-question-circle-o" aria-hidden="true"></span>
                                            <div class="tooltip">
                                                <div class="tooltip__background"></div>
                                                <span class="tooltip__label" data-var="refund-message-collapsed"></span>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="custom-input">
                                        <input type="text" name="message-collapsed" value="Premium content unlocked. notSatisfied_url Get immediate" placeholder="Premium content unlocked. notSatisfied_url Get immediate" required="" />
                                        <span class="bar"></span>
                                    </div>
                                </div>

                                <div class="flex-container flex-gutter" data-template="style">
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Color</label>
                                            <div class="custom-input">
                                                <input type="color" data-template-css="color" placeholder="#404040" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Font Size</label>
                                            <div class="custom-input">
                                                <input type="text" data-template-css="font-size" placeholder="13px" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Font Weight</label>
                                            <div class="form-select">
                                                <select data-template-css="font-weight">
                                                    <option selected>normal</option>
                                                    <option>bold</option>
                                                    <option>bolder</option>
                                                    <option>lighter</option>
                                                    <option>100</option>
                                                    <option>200</option>
                                                    <option>300</option>
                                                    <option>400</option>
                                                    <option>500</option>
                                                    <option>600</option>
                                                    <option>700</option>
                                                    <option>800</option>
                                                    <option>900</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-container flex-gutter" data-template="style">
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Font Style</label>
                                            <div class="form-select">
                                                <select data-template-css="font-style">
                                                    <option selected>normal</option>
                                                    <option>italic</option>
                                                    <option>oblique</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Text Align</label>
                                            <div class="form-select">
                                                <select data-template-css="text-align">
                                                    <option selected>left</option>
                                                    <option>right</option>
                                                    <option>center</option>
                                                    <option>justify</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Text Transform</label>
                                            <div class="form-select">
                                                <select data-template-css="text-transform">
                                                    <option selected>none</option>
                                                    <option>capitalize</option>
                                                    <option>uppercase</option>
                                                    <option>lowercase</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <input id="refund-ext-mood" name="refund-ext" type="radio">
                            <label for="refund-ext-mood" class="tab-name">
                                Mood
                            </label>
                            <div class="tab-content" >
                                <div class="custom-label" data-template="mood">
                                    <label>Message</label>
                                    <div class="custom-input" data-template="expanded">
                                        <input type="text" name="body-feeling" value="How do you feel now?" placeholder="How do you feel now?" required="" />
                                        <span class="bar"></span>
                                    </div>
                                </div>

                                <div class="flex-container flex-gutter" data-template="mood">
                                    <div class="flex-item-4" data-template="style">
                                        <div class="custom-label">
                                            <label>Color</label>
                                            <div class="custom-input">
                                                <input type="color" data-template-css="color" placeholder="#404040" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4" data-template="style">
                                        <div class="custom-label">
                                            <label>Font Size</label>
                                            <div class="custom-input">
                                                <input type="text" data-template-css="font-size" placeholder="13px" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4" data-template="style">
                                        <div class="custom-label">
                                            <label>Font Weight</label>
                                            <div class="form-select">
                                                <select data-template-css="font-weight">
                                                    <option selected>normal</option>
                                                    <option>bold</option>
                                                    <option>bolder</option>
                                                    <option>lighter</option>
                                                    <option>100</option>
                                                    <option>200</option>
                                                    <option>300</option>
                                                    <option>400</option>
                                                    <option>500</option>
                                                    <option>600</option>
                                                    <option>700</option>
                                                    <option>800</option>
                                                    <option>900</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-container flex-gutter" data-template="mood">
                                    <div class="flex-item-4" data-template="style">
                                        <div class="custom-label">
                                            <label>Font Style</label>
                                            <div class="form-select">
                                                <select data-template-css="font-style">
                                                    <option selected>normal</option>
                                                    <option>italic</option>
                                                    <option>oblique</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4" data-template="style">
                                        <div class="custom-label">
                                            <label>Text Align</label>
                                            <div class="form-select">
                                                <select data-template-css="text-align">
                                                    <option selected>left</option>
                                                    <option>right</option>
                                                    <option>center</option>
                                                    <option>justify</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4" data-template="style">
                                        <div class="custom-label">
                                            <label>Text Transform</label>
                                            <div class="form-select">
                                                <select data-template-css="text-transform">
                                                    <option selected>none</option>
                                                    <option>capitalize</option>
                                                    <option>uppercase</option>
                                                    <option>lowercase</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-container flex-gutter"  data-template="mood-happy">
                                    <div class="flex-item-6" data-template="expanded">
                                        <div class="custom-label">
                                            <label>Happy Mood Text</label>
                                            <div class="custom-input">
                                                <input type="text" name="body-feeling-happy" value="Happy" placeholder="Happy" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-6" data-template="style">
                                        <div class="custom-label">
                                            <label>Happy Mood Color</label>
                                            <div class="custom-input">
                                                <input type="color" data-template-css="color" placeholder="#92c563" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-container flex-gutter" data-template="mood-ok">
                                    <div class="flex-item-6"  data-template="expanded">
                                        <div class="custom-label">
                                            <label>Neutral Mood Text</label>
                                            <div class="custom-input">
                                                <input type="text" name="body-feeling-ok" value="OK" placeholder="Ok" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-6" data-template="style">
                                        <div class="custom-label">
                                            <label>Neutral Mood Color</label>
                                            <div class="custom-input">
                                                <input type="color" data-template-css="color" placeholder="#eed16a" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-container flex-gutter" data-template="mood-not-happy">
                                    <div class="flex-item-6" data-template="expanded">
                                        <div class="custom-label">
                                            <label>Not happy Mood Text</label>
                                            <div class="custom-input">
                                                <input type="text" name="body-feeling-not-happy" value="Not happy" placeholder="Not happy" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-6" data-template="style">
                                        <div class="custom-label">
                                            <label>Not happy Mood Color</label>
                                            <div class="custom-input">
                                                <input type="color" data-template-css="color" placeholder="#e27378" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <input id="refund-ext-share" name="refund-ext" type="radio">
                            <label for="refund-ext-share" class="tab-name">
                                Share
                            </label>
                            <div class="tab-content" data-template="share">
                                <div class="custom-label" data-template="expanded">
                                    <label>Message</label>
                                    <div class="custom-input">
                                        <input type="text" name="body-share-experience" value="Share your experience" placeholder="Share your experience" required="" />
                                        <span class="bar"></span>
                                    </div>
                                </div>

                                <div class="flex-container flex-gutter" data-template="style">
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Color</label>
                                            <div class="custom-input">
                                                <input type="color" data-template-css="color" placeholder="#404040" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Font Size</label>
                                            <div class="custom-input">
                                                <input type="text" data-template-css="font-size" placeholder="13px" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Font Weight</label>
                                            <div class="form-select">
                                                <select data-template-css="font-weight">
                                                    <option selected>normal</option>
                                                    <option>bold</option>
                                                    <option>bolder</option>
                                                    <option>lighter</option>
                                                    <option>100</option>
                                                    <option>200</option>
                                                    <option>300</option>
                                                    <option>400</option>
                                                    <option>500</option>
                                                    <option>600</option>
                                                    <option>700</option>
                                                    <option>800</option>
                                                    <option>900</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-container flex-gutter" data-template="style">
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Font Style</label>
                                            <div class="form-select">
                                                <select data-template-css="font-style">
                                                    <option selected>normal</option>
                                                    <option>italic</option>
                                                    <option>oblique</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Text Align</label>
                                            <div class="form-select">
                                                <select data-template-css="text-align">
                                                    <option selected>left</option>
                                                    <option>right</option>
                                                    <option>center</option>
                                                    <option>justify</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Text Transform</label>
                                            <div class="form-select">
                                                <select data-template-css="text-transform">
                                                    <option selected>none</option>
                                                    <option>capitalize</option>
                                                    <option>uppercase</option>
                                                    <option>lowercase</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-container flex-gutter">
                                    <div class="flex-item-6">
                                        <div class="custom-label">
                                            <label>Share Tool</label>
                                            <div class="custom-input">
                                                <input type="text" value="fa-facebook" placeholder="fa-facebook" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-6">
                                        <div class="custom-label">
                                            <label>Share Tool Color</label>
                                            <div class="custom-input">
                                                <input type="color" placeholder="#3B579D" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-container flex-gutter">
                                    <div class="flex-item-6">
                                        <div class="custom-label">
                                            <label>Share Tool</label>
                                            <div class="custom-input">
                                                <input type="text" value="fa-twitter" placeholder="fa-twitter" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-6">
                                        <div class="custom-label">
                                            <label>Share Tool Color</label>
                                            <div class="custom-input">
                                                <input type="color" placeholder="#4AC7F9" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-container flex-gutter">
                                    <div class="flex-item-6">
                                        <div class="custom-label">
                                            <label>Share Tool</label>
                                            <div class="custom-input">
                                                <input type="text" value="fa-email" placeholder="fa-email" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-6">
                                        <div class="custom-label">
                                            <label>Share Tool Color</label>
                                            <div class="custom-input">
                                                <input type="color" placeholder="#ff0000" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-container flex-gutter">
                                    <div class="flex-item-6">
                                        <div class="custom-label">
                                            <label>Share Tool</label>
                                            <div class="custom-input">
                                                <input type="text" value="fa-share" placeholder="fa-share" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-6">
                                        <div class="custom-label">
                                            <label>Share Tool Color</label>
                                            <div class="custom-input">
                                                <input type="color" placeholder="#000000" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <input id="refund-ext-button" name="refund-ext" type="radio">
                            <label for="refund-ext-button" class="tab-name">
                                Button
                            </label>
                            <div class="tab-content">
                                <div class="flex-container flex-gutter">
                                    <div class="flex-item-6">
                                        <div class="custom-label">
                                            <label>Refund Button Text</label>
                                            <div class="custom-input">
                                                <input type="text" value="REFUND" placeholder="REFUND" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-6">
                                        <div class="custom-label">
                                            <label>Refund Button Icon</label>
                                            <div class="custom-input">
                                                <input type="text" value="fa-money" placeholder="fa-money" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-container flex-gutter">
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Background Color</label>
                                            <div class="custom-input">
                                                <input type="color" placeholder="#1b93f2" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Border</label>
                                            <div class="custom-input">
                                                <input type="text" placeholder="1px solid #1b93f2" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Font Size</label>
                                            <div class="custom-input">
                                                <input type="text" placeholder="11px" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-container flex-gutter">
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Font Weight</label>
                                            <div class="form-select">
                                                <select data-template-css="font-weight">
                                                    <option selected>normal</option>
                                                    <option>bold</option>
                                                    <option>bolder</option>
                                                    <option>lighter</option>
                                                    <option>100</option>
                                                    <option>200</option>
                                                    <option>300</option>
                                                    <option>400</option>
                                                    <option>500</option>
                                                    <option>600</option>
                                                    <option>700</option>
                                                    <option>800</option>
                                                    <option>900</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Border Radius</label>
                                            <div class="custom-input">
                                                <input type="text" placeholder="2px" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Color</label>
                                            <div class="custom-input">
                                                <input type="color" placeholder="#ffffff" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-container flex-gutter">
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Font Style</label>
                                            <div class="form-select">
                                                <select data-template-css="font-style">
                                                    <option selected>normal</option>
                                                    <option>italic</option>
                                                    <option>oblique</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Text Align</label>
                                            <div class="form-select">
                                                <select data-template-css="text-align">
                                                    <option selected>left</option>
                                                    <option>right</option>
                                                    <option>center</option>
                                                    <option>justify</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Text Transform</label>
                                            <div class="form-select">
                                                <select data-template-css="text-transform">
                                                    <option selected>none</option>
                                                    <option>capitalize</option>
                                                    <option>uppercase</option>
                                                    <option>lowercase</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <input id="refund-ext-arrow" name="refund-ext" type="radio">
                            <label for="refund-ext-arrow" class="tab-name">
                                Arrow
                            </label>
                            <div class="tab-content">
                                <div class="flex-container flex-gutter">
                                    <div class="flex-item-6">
                                        <div class="custom-label">
                                            <label>Closing Arrow</label>
                                            <div class="custom-input">
                                                <input type="text" value="fa-chevron-circle-up" placeholder="fa-chevron-circle-up" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-6">
                                        <div class="custom-label">
                                            <label>Color</label>
                                            <div class="custom-input">
                                                <input type="color" value="#404040" placeholder="#404040" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-container flex-gutter">
                                    <div class="flex-item-6">
                                        <div class="custom-label">
                                            <label>Opening Arrow</label>
                                            <div class="custom-input">
                                                <input type="text" value="fa-chevron-circle-down" placeholder="fa-chevron-circle-down" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-6">
                                        <div class="custom-label">
                                            <label>Color</label>
                                            <div class="custom-input">
                                                <input type="color" value="#404040" placeholder="#404040" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </section>
                    </div>
                </div>
                <div class="custom-input pull-right">
                    <button type="button" class="btn save-templates"><i class="mdi mdi-check"></i> Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="templates-views other">
        <div class="template-view">
            <div class="header-view">other templates <i class="fa fa-angle-right"
                                                        aria-hidden="true"></i> unlock view
            </div>
            <div class="content-view">
                <div class="flex-container">
                    <div class="flex-item-6">
                        <div class="atm-base-modal">
                            <div class="atm-main price-view">
                                <div class="unlock-cont">
                                    <p class="blurred">
                                        It is a long established fact that a reader will be
                                        distracted
                                        by
                                        the readable content of a page when looking at its layout.
                                        The point of using Lorem Ipsum is that it has a more-or-less
                                        normal
                                        distribution of letters, as opposed to using 'Content here,
                                        content here',
                                        making it look like readable English.
                                        It is a long established fact that a reader will be
                                        distracted
                                        by
                                        the readable content of a page when looking at its layout.
                                        The point of using Lorem Ipsum is that it has a more-or-less
                                        normal
                                        distribution of letters, as opposed to using 'Content here,
                                        content here',
                                        making it look like readable English.
                                    </p>
                                    <button class="atm-button unlock-btn">
                                        <i class="fa fa-unlock-alt" aria-hidden="true"></i> unlock
                                        content
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex-item-6">
                        <section class="config-tabs">
                            <input id="other-unlock" name="unlock-content" checked="" type="radio">
                            <label for="other-unlock" class="tab-name">
                                Button
                            </label>
                            <div class="tab-content">
                                <div class="flex-container flex-gutter">
                                    <div class="flex-item-6">
                                        <div class="custom-label">
                                            <label>Unlock Button Text</label>
                                            <div class="custom-input">
                                                <input type="text" value="UNLOCK CONTENT" placeholder="UNLOCK CONTENT" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-6">
                                        <div class="custom-label">
                                            <label>Unlock Button Icon</label>
                                            <div class="custom-input">
                                                <input type="text" value="fa-unlock-alt" placeholder="fa-unlock-alt" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-container flex-gutter">
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Background Color</label>
                                            <div class="custom-input">
                                                <input type="color" placeholder="#1b93f2" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Border</label>
                                            <div class="custom-input">
                                                <input type="text" placeholder="1px solid #1b93f2" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Font Size</label>
                                            <div class="custom-input">
                                                <input type="text" placeholder="11px" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-container flex-gutter">
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Font Weight</label>
                                            <div class="form-select">
                                                <select data-template-css="font-weight">
                                                    <option selected>normal</option>
                                                    <option>bold</option>
                                                    <option>bolder</option>
                                                    <option>lighter</option>
                                                    <option>100</option>
                                                    <option>200</option>
                                                    <option>300</option>
                                                    <option>400</option>
                                                    <option>500</option>
                                                    <option>600</option>
                                                    <option>700</option>
                                                    <option>800</option>
                                                    <option>900</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Border Radius</label>
                                            <div class="custom-input">
                                                <input type="text" placeholder="2px" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Color</label>
                                            <div class="custom-input">
                                                <input type="color" placeholder="#ffffff" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-container flex-gutter">
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Font Style</label>
                                            <div class="form-select">
                                                <select data-template-css="font-style">
                                                    <option selected>normal</option>
                                                    <option>italic</option>
                                                    <option>oblique</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Text Align</label>
                                            <div class="form-select">
                                                <select data-template-css="text-align">
                                                    <option selected>left</option>
                                                    <option>right</option>
                                                    <option>center</option>
                                                    <option>justify</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Text Transform</label>
                                            <div class="form-select">
                                                <select data-template-css="text-transform">
                                                    <option selected>none</option>
                                                    <option>capitalize</option>
                                                    <option>uppercase</option>
                                                    <option>lowercase</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>

        <div class="template-view">
            <div class="header-view">other templates <i class="fa fa-angle-right"
                                                        aria-hidden="true"></i> price view
            </div>
            <div class="content-view">
                <div class="flex-container">
                    <div class="flex-item-6">
                        <div class="atm-base-modal">
                            <div class="atm-main price-view">
                                <p class="blurred">Dear reader,</p>
                                <div>
                                    <span class="blurred">Please support quality journalism</span>
                                    <span class="contrib-price">5¢</span> <span class="blurred">to continue reading?</span>
                                    <span class="show-sm blurred">lease support quality journalism lease support quality journalism lease support quality journalism</span>
                                </div>
                                <div class="pledge-bottom clearfix blurred">
                                    <div class="connect-component">
                                        <small>
                                            Already used us before? <a>Connect here</a>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex-item-6">
                        <section class="config-tabs">
                            <input id="other-price" name="other-view-price" checked="" type="radio">
                            <label for="other-price" class="tab-name">
                                Price
                            </label>
                            <div class="tab-content">
                                <div class="custom-label">
                                    <label>Price</label>
                                    <div class="custom-input">
                                        <input type="text" value="{price}" placeholder="{price}" required="" />
                                        <span class="bar"></span>
                                    </div>
                                </div>

                                <div class="flex-container flex-gutter">
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Background Color</label>
                                            <div class="custom-input">
                                                <input type="color" placeholder="#f3f3f3" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Border</label>
                                            <div class="custom-input">
                                                <input type="text" placeholder="1px solid #d3d3d3" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Border Radius</label>
                                            <div class="custom-input">
                                                <input type="text" placeholder="50%" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-container flex-gutter">
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Color</label>
                                            <div class="custom-input">
                                                <input type="color" placeholder="#404040" required="" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Font Style</label>
                                            <div class="form-select">
                                                <select data-template-css="font-style">
                                                    <option selected>normal</option>
                                                    <option>italic</option>
                                                    <option>oblique</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-item-4">
                                        <div class="custom-label">
                                            <label>Font Weight</label>
                                            <div class="form-select">
                                                <select data-template-css="font-weight">
                                                    <option selected>normal</option>
                                                    <option>bold</option>
                                                    <option>bolder</option>
                                                    <option>lighter</option>
                                                    <option>100</option>
                                                    <option>200</option>
                                                    <option>300</option>
                                                    <option>400</option>
                                                    <option>500</option>
                                                    <option>600</option>
                                                    <option>700</option>
                                                    <option>800</option>
                                                    <option>900</option>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
        <div class="custom-input pull-right">
            <button type="button" class="btn save-templates"><i class="mdi mdi-check"></i> Save</button>
        </div>
    </div>
</section>
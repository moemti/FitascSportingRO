@stack('footer_start')
 <div class="app-wrapper-footer">
                    <div class="app-footer">
                        <div class="app-footer__inner">
                            <div class="app-footer-left">
                                <div class="footer-dots">
                                    <div class="dropdown">
                                        <a class="dot-btn-wrapper" aria-haspopup="true" data-toggle="dropdown" aria-expanded="false">
                                            <i class="dot-btn-icon lnr-earth icon-gradient bg-happy-itmeo">
                                            </i>
                                        </a>
                                        <div tabindex="-1" role="menu" aria-hidden="true" class="rm-pointers dropdown-menu">
                                            <div class="dropdown-menu-header">
                                                <div class="dropdown-menu-header-inner pt-4 pb-4 bg-focus">
                                                    <div class="menu-header-image opacity-05" style="background-image: url('assets/images/dropdown-header/city2.jpg');"></div>
                                                    <div class="menu-header-content text-center text-white">
                                                        <h6 class="menu-header-subtitle mt-0">
                                                            Choose Language
                                                        </h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <h6 tabindex="-1" class="dropdown-header">
                                                Choose Language
                                            </h6>
                                            <button type="button" tabindex="0" class="dropdown-item" onclick="setLanguage('GB')">
                                                <span class="mr-3 opacity-8 flag large GB"></span>
                                                English
                                            </button>
                                            <button type="button" tabindex="0" class="dropdown-item" onclick="setLanguage('RO')">
                                                <span class="mr-3 opacity-8 flag large RO"></span>
                                                Romanian
                                            </button>

                                        </div>
                                    </div>
                                </div>        
                            </div>

                        </div>
                    </div>
                </div>
@stack('footer_end')

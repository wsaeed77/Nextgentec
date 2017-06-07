<div>
    <div ng-show="ready">
        <div class="f14 b titleBeforeBreak t24">
            Contacts
            <span class="r">
                <a ng-href="#/contact/add">
                    <span class="glyphicon glyphicon-plus p span-black" ng-click="addContact()">
                    </span>
                </a>
            </span>
        </div>
        <div class="breakgray"></div>
        <br />
        <div class="row">
            <div class="col-lg-4 col-md-6 col-xs-12 contact-in-costumer-panel" ng-repeat="contact in contacts" data-contact-first-name="{{::contact.Firstname }}" data-contact-last-name="{{::contact.Lastname }}">
                <div class="well oh" ng-class="contact.IsContactPerson ? 'well-navy rel' : ''">
                    <div class="pull-right d" ng-show="contact.IsContactPerson" style="margin-top: 0px; margin-right: 0px;" data-toggle="tooltip" tooltip-placement="bottom" tooltip="Contact Person">
                        <i class="fa fa-asterisk f24"></i>
                    </div>
                    <div>
                        <i class="fa fa-user fa-fw"></i> <a href="#/contact/{{ contact.EndUserID }}" style="color: #8FBC24;" title="{{ contact.Firstname }} {{ contact.Lastname }}">{{ contact.Firstname || 'n/a' }} {{ contact.Lastname || 'n/a' }}</a>
                    </div>
                    <div title="Job title: {{ contact.JobTitle }}">
                        <i class="fa fa-bookmark fa-fw"></i> {{ contact.JobTitle || 'n/a' }}
                    </div>
                    <div title="Phone: {{ contact.Phone }}">
                        <i class="fa fa-phone fa-fw"></i> {{ contact.Phone || 'n/a' }}
                    </div>
                    <div title="Email: {{ contact.Email }}">
                        <i class="fa fa-at fa-fw"></i> <a href="mailto:{{ contact.Email }}">{{ contact.Email }}</a>
                    </div>
                    <div title="Last modified: {{ contact.LastModified | date:'mediumDate' }}">
                        <i class="fa fa-calendar-check-o fa-fw"></i> {{ contact.LastModified | date:'mediumDate' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div ng-show="!ready" style="text-align: center; margin: 32px; font-size: 32px;">
        <img src="../../../Images/loading-small.gif" />
    </div>
</div>

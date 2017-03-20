({
  fireGetBankFeedTypes : function(component) {
      var action = component.get("c.getFeedBrokers");
      action.setCallback(this, function(response) {
          var state = response.getState();
          if (state === "SUCCESS") {
                            var retVal = response.getReturnValue();
                            var brokers = [];
                            for(var i = 0; i < retVal.length; i++)
                            {
                                var name = retVal[i].s2cor__Class_Name__c;
                                if (name == null) name = retVal[i].Class_Name__c;
                                brokers.push({value: retVal[i].Id, label: name})
                            }
              component.set("v.feedBrokers", brokers);

              this.renderOutput(component);
          }
      });
      $A.enqueueAction(action);
  },
  fireGetBankFeedNames : function(component) {
      var action = component.get("c.getFeeds");
            var brokerId = component.get("v.feedType");
            action.setParams({ brokerId : brokerId.value });
      action.setCallback(this, function(response) {
          var state = response.getState();
          if (state === "SUCCESS") {
                            var retVal = response.getReturnValue();

                            var feeds = [];
                            for(var i = 0; i < retVal.length; i++)
                            {
                                feeds.push({label: retVal[i].Name, value: retVal[i].Id})
                            }
              component.set("v.feedNames", feeds);

              this.renderOutput(component);
          }
      });
      $A.enqueueAction(action);
  },
  fireGetBankStatement : function(component) {
      var action = component.get("c.getBankStatement");
            var feedId = component.get("v.feedName");

            //action.setParams({feedId: feedId});
            action.setParams({ feedId : feedId.value });
      action.setCallback(this, function(response) {
          var state = response.getState();
          if (state === "SUCCESS") {
                            var retVal = response.getReturnValue();
                            var statement = JSON.parse(retVal);

                            if (statement.bankAccountTag)
                            {
                                component.set("v.accountTag", statement.bankAccountTag);
                            }
                            else component.set("v.accountTag", []);
              component.set("v.bankStatement", retVal);

              this.renderOutput(component);
          }
      });
      $A.enqueueAction(action);
  },
  registerGetFeedBrokersHandler : function(component) {
      var handleEvent = function(e) {
          e.stopPropagation();
          var event = $A.get("e.s2cor:Sage_ACC_BankStmnt_FeedTypeChangedEvent");
                    event.setParams({"feedType": e.detail});
                    event.fire();
      }
      var filterElement = component.find("bankFeedType").getElement();
      filterElement.addEventListener("changeOption", $A.getCallback(handleEvent), false);
  },
  registerGetFeedsHandler : function(component) {
      var handleEvent = function(e) {
          e.stopPropagation();
          var event = $A.get("e.s2cor:Sage_ACC_BankStmnt_FeedNameChangedEvent");
                    event.setParams({"feedName": e.detail});
                    event.fire();
      }
      var filterElement = component.find("bankFeedName").getElement();
      filterElement.addEventListener("changeOption", $A.getCallback(handleEvent), false);
  },
  renderOutput : function(component) {
        this.showMainSpinner(component, true);
        var bankFeedType = component.find("bankFeedType").getElement();
        var bankFeedName = component.find("bankFeedName").getElement();
        var bankAccountTag = component.find("bankAccountTag").getElement();

        var feedBrokers = component.get("v.feedBrokers");
        var feedNames = component.get("v.feedNames");

        var accountTag = component.get("v.accountTag");
        var feedType = component.get("v.feedType");
        var feedName = component.get("v.feedName");

        var bankFeedIdParam = component.get("v.bankFeedIdParam");

        Carbon.ReactDOM.render(
            Carbon.React.createElement(Carbon.DataDropdown, {
                    required: true,
                    disabled: (bankFeedIdParam && bankFeedIdParam.length > 0),
                    includeBlankOption: true,
                    label: $A.get("$Label.s2cor.VF_Bank_Statement_Feed_Type_Select"),
                    options:feedBrokers,
                    defaultOption: feedType,
                    blankOptionPrompt: '- None -',
            }),
            bankFeedType
        );

        Carbon.ReactDOM.render(
            Carbon.React.createElement(Carbon.DataDropdown, {
                    required: true,
                    disabled: (bankFeedIdParam && bankFeedIdParam.length > 0),
                    label: $A.get("$Label.s2cor.VF_Bank_Statement_Feed_Name_Select"),
                    includeBlankOption: true,
                    options:feedNames,
                    defaultOption: feedName,
                    blankOptionPrompt: '- None -',
            }),
            bankFeedName
        );

        Carbon.ReactDOM.render(
            Carbon.React.createElement(Carbon.DataDropdown, {
                    disabled: true,
                    label: $A.get("$Label.s2cor.VF_Bank_Statement_Bank_Tag"),
                    includeBlankOption: true,
                    blankOptionPrompt: accountTag,
                    options: (accountTag && accountTag.length > 0 ? [{value: "1", label: accountTag[0]}] : []),
                    defaultOption: accountTag,
            }),
            bankAccountTag
        );

        this.renderBankStatement(component);
        this.showMainSpinner(component, false);
        this.fixIcons(component);

    },
    renderBankStatement: function(component) {
        var statementDetails = component.find("statement-details").getElement();
        var noTagError = component.find("statement-details-no-tag").getElement();
        var importedBankBalance = component.find("imported-bank-balance").getElement();
        var calculatedBalance = component.find("sage-live-calculated-balance").getElement();
        var difference = component.find("difference").getElement();
        var bankStatementDetail = component.find("bank-statement-detail").getElement();
        var adjustedCashBalance = component.find("adjusted-cash-balance").getElement();

        var locale = $A.get("$Locale.userLocaleLang");
        var currencyCode = $A.get("$Locale.currencyCode");

        var bankStatement = component.get("v.bankStatement");
        bankStatement = JSON.parse(bankStatement);
        if (!bankStatement)
        {
            statementDetails.setAttribute('class', 'sagelive-slds-hide');
            return;
        }

        if (!bankStatement.bankAccountTagId)
        {
            statementDetails.setAttribute('class', 'sagelive-slds-hide');
            noTagError.setAttribute('class', 'sagelive-slds-notify sagelive-slds-notify--alert sagelive-slds-theme--error sagelive-slds-theme--alert-texture');
            return;
        }
        else {
            statementDetails.removeAttribute('class', 'sagelive-slds-hide');
            noTagError.setAttribute('class', 'sagelive-slds-hide');
        }

    var journalItems = (bankStatement.journalItems && bankStatement.journalItems.length > 0 ? bankStatement.journalItems : null);
    if (journalItems)
    {
        //var dateFormat = "MMM d, yyyy";
        var d = 0;
        var c = 0;
        for (var i =0; i < journalItems.length; i++)
        {
            var journalDate = new Date(journalItems[i].itemDate).toLocaleDateString(locale, {
                day : 'numeric',
                month : 'short',
                year : 'numeric'
            });
            journalItems[i].balance = '';
            journalItems[i].itemDate = journalDate;
            d += journalItems[i].debit;
            c += journalItems[i].credit;
        }
        journalItems.push({journal: "", journal_item: $A.get("$Label.s2cor.VF_Bank_Statement_Subtotal"), itemDate:"", debit: d, credit: c, balance: bankStatement.unpostedTotal});
    }

        var detailItems = [
            {
                title: $A.get("$Label.s2cor.VF_Bank_Statement_Imported_Bank_Balance"),
                amount: bankStatement.importedBankBalance,
                emphasis: true,
            },
            {
                title: $A.get("$Label.s2cor.VF_Bank_Statement_Bank_Balance"),
                amount: bankStatement.tagBaseBalance,
            },
            {
                title: $A.get("$Label.s2cor.VF_Bank_Statement_Unposted_Feed_Items"),
                amount: bankStatement.unpostedTotal,
            table: journalItems,
        tableIncludesTotal: true,
        tableHeaders: {journalName: {title: $A.get("$Label.s2cor.VF_Bank_Statement_Journal_Name")},
                       itemName: {title: $A.get("$Label.s2cor.VF_Bank_Statement_Journal_Item_Name")},
                       itemDate: {title: $A.get("$Label.s2cor.VF_Bank_Statement_Journal_Item_Date")},
                       debit: {title: $A.get("$Label.s2cor.VF_Bank_Statement_Journal_Item_Debit"),
                               type: "currency"},
                       credit: {title: $A.get("$Label.s2cor.VF_Bank_Statement_Journal_Item_Credit"),
                               type: "currency"},
                       balance: {title: $A.get("$Label.s2cor.VF_Bank_Statement_Journal_Item_Balance"),
                               type: "currency"}
                      },
                tablePagination: {offset: 0, limit: 5, total: (journalItems ? journalItems.length : 0), alwaysOn: false}
            },
            {
                title: $A.get("$Label.s2cor.VF_Bank_Statement_Calculated_Balance"),
                amount: bankStatement.calculatedBankBalance,
                rule: true,
                emphasis: true,
            },
            {
                title: $A.get("$Label.s2cor.VF_Bank_Statement_Difference"),
                amount: bankStatement.importedCalculatedDifference,
                emphasis: true,
            }
        ];

        var cashClearingSummary = [];
        if (bankStatement.ledgerAccounts)
        {
            for (i = 0; i < bankStatement.ledgerAccounts.length; i ++)
            {
                cashClearingSummary.push({title: bankStatement.ledgerAccounts[i].ledgerAccountName, value: bankStatement.ledgerAccounts[i].accountSubTotal})
            }
        }
    if (cashClearingSummary.length > 0) {
        cashClearingSummary.push({title: $A.get("$Label.s2cor.VF_Bank_Statement_Cash_Clearning_Sub"), value: bankStatement.cashClearningSubTotal, total: true})
    }

        var adjustedItems = [
            {
                title: $A.get("$Label.s2cor.VF_Bank_Statement_Calculated_Balance"),
                amount: bankStatement.calculatedBankBalance,
                emphasis: true,
            },
            {
                title: $A.get("$Label.s2cor.VF_Bank_Statement_Cash_Clearning_Title"),
                amount: bankStatement.cashClearningSubTotal,
                summary: (cashClearingSummary.length > 0 ? cashClearingSummary : null),
            },
            {
                title: $A.get("$Label.s2cor.VF_Bank_Statement_Adjust_Cash_Title"),
                amount: bankStatement.adjustedCashBalance,
                emphasis: true,
            }
        ];

        var dateString = new Date().toLocaleDateString(locale, {
                day : 'numeric',
                month : 'short',
                year : 'numeric'
            });

        Carbon.ReactDOM.render(
            Carbon.React.createElement(Carbon.BankStatementTotal, {
                    title: $A.get("$Label.s2cor.VF_Bank_Statement_Imported_Bank_Balance"),
                    date: dateString,
                    currencyCode: currencyCode,
                    UserLocale: locale,
                    labels: {AsOf: $A.get("$Label.s2cor.VF_Generic_As_Of")},
                    amount: bankStatement.importedBankBalance,
            }),
            importedBankBalance
        );

        Carbon.ReactDOM.render(
            Carbon.React.createElement(Carbon.BankStatementTotal, {
                    title: $A.get("$Label.s2cor.VF_Bank_Statement_Calculated_Balance"),
                    date: dateString,
                    currencyCode: currencyCode,
                    UserLocale: locale,
                    labels: {AsOf: $A.get("$Label.s2cor.VF_Generic_As_Of")},
                    amount: bankStatement.calculatedBankBalance,
            }),
            calculatedBalance
        );

        Carbon.ReactDOM.render(
        Carbon.React.createElement(Carbon.BankStatementTotal, {

            title: $A.get("$Label.s2cor.VF_Bank_Statement_Difference"),
            date: dateString,
                    currencyCode: currencyCode,
                    UserLocale: locale,
                    labels: {AsOf: $A.get("$Label.s2cor.VF_Generic_As_Of")},
            amount: bankStatement.importedCalculatedDifference,
        }),
        difference
      );

        var labels = {
            CloseDetail: $A.get("$Label.s2cor.VF_Generic_Close_Detail"),
            ViewDetail: $A.get("$Label.s2cor.VF_Generic_View_Detail")
        }

        Carbon.ReactDOM.render(
            Carbon.React.createElement(Carbon.BankStatementDetail, {
                    title: $A.get("$Label.s2cor.VF_Bank_Statement_Detail_Title"),
                    items: detailItems,
                    currencyCode: currencyCode,
                    UserLocale: locale,
                    labels: labels
            }),
            bankStatementDetail
        );

        Carbon.ReactDOM.render(
            Carbon.React.createElement(Carbon.BankStatementDetail, {
                    title: $A.get("$Label.s2cor.VF_Bank_Statement_Adjust_Cash_Title"),
                    items: adjustedItems,
                    currencyCode: currencyCode,
                    UserLocale: locale,
                    labels: labels
            }),
            adjustedCashBalance
        );
    },
    showMainSpinner: function(component, show) {
    var spinner = document.getElementById("mainSpinner");
        if (!spinner) return;
        if (show) {
            spinner.removeAttribute('class', 'sagelive-slds-hide');
        } else {
            spinner.setAttribute('class', 'sagelive-slds-hide');
        }
    },
        fixIcons : function(component) {
        var sageCarbonResource = component.get("v.sageCarbon");
        var sageCarbonResourcePath = '/resource/' + sageCarbonResource;
        var iconElements = document.getElementsByTagName("svg");
        if (iconElements)
        {
            var len = iconElements.length;
                    for (var i=0; i<len; ++i) {
            var iconElement = iconElements[i];
            this.fixSVG(sageCarbonResourcePath, iconElement);
                    }
        }
        var imageElements = document.getElementsByTagName("img");
        if (imageElements)
        {
            var imgLen = imageElements.length;
                        for (i=0; i<imgLen; ++i) {
            var imageElement = imageElements[i];
            this.fixIMG(sageCarbonResourcePath, imageElement);
                    }
        }
    },

    fixSVG : function(sageCarbonResourcePath, svg) {
        if (!svg) return;

        var hidden = svg.getAttribute('aria-hidden').toString();
        if (hidden !== 'true') return;

            var useNode = svg.firstElementChild;
        if (!useNode) return;

        //Replace the url
        var originalUrl = useNode.getAttribute('xlink:href');
        if (originalUrl.length > 0) {
            var start = originalUrl.substring(0, 8);
            if (start === "/assets/")
            {
                var imageURL = sageCarbonResourcePath + originalUrl;
                useNode.setAttribute('xlink:href', imageURL);
                svg.setAttribute('aria-hidden', 'false');
            }
        }
    },

    fixIMG : function(sageCarbonResourcePath, img) {
        if (!img) return;

        //Replace the url
        var originalUrl = img.getAttribute('src');
        if (originalUrl.length > 0) {
            var start = originalUrl.substring(0, 8);
            if (start === "/assets/")
            {
                var imageURL = sageCarbonResourcePath + originalUrl;
                img.setAttribute('src', imageURL);
            }
        }
    },
})
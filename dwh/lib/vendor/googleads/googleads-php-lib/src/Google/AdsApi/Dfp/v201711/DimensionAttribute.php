<?php

namespace Google\AdsApi\Dfp\v201711;


/**
 * This file was generated from WSDL. DO NOT EDIT.
 */
class DimensionAttribute
{
    const LINE_ITEM_LABELS = 'LINE_ITEM_LABELS';
    const LINE_ITEM_LABEL_IDS = 'LINE_ITEM_LABEL_IDS';
    const LINE_ITEM_OPTIMIZABLE = 'LINE_ITEM_OPTIMIZABLE';
    const LINE_ITEM_DELIVERY_INDICATOR = 'LINE_ITEM_DELIVERY_INDICATOR';
    const LINE_ITEM_DELIVERY_PACING = 'LINE_ITEM_DELIVERY_PACING';
    const LINE_ITEM_FREQUENCY_CAP = 'LINE_ITEM_FREQUENCY_CAP';
    const LINE_ITEM_RECONCILIATION_STATUS = 'LINE_ITEM_RECONCILIATION_STATUS';
    const LINE_ITEM_LAST_RECONCILIATION_DATE_TIME = 'LINE_ITEM_LAST_RECONCILIATION_DATE_TIME';
    const ADVERTISER_EXTERNAL_ID = 'ADVERTISER_EXTERNAL_ID';
    const ADVERTISER_TYPE = 'ADVERTISER_TYPE';
    const ADVERTISER_CREDIT_STATUS = 'ADVERTISER_CREDIT_STATUS';
    const ADVERTISER_PRIMARY_CONTACT = 'ADVERTISER_PRIMARY_CONTACT';
    const ORDER_START_DATE_TIME = 'ORDER_START_DATE_TIME';
    const ORDER_END_DATE_TIME = 'ORDER_END_DATE_TIME';
    const ORDER_EXTERNAL_ID = 'ORDER_EXTERNAL_ID';
    const ORDER_PO_NUMBER = 'ORDER_PO_NUMBER';
    const ORDER_IS_PROGRAMMATIC = 'ORDER_IS_PROGRAMMATIC';
    const ORDER_AGENCY = 'ORDER_AGENCY';
    const ORDER_AGENCY_ID = 'ORDER_AGENCY_ID';
    const ORDER_LABELS = 'ORDER_LABELS';
    const ORDER_LABEL_IDS = 'ORDER_LABEL_IDS';
    const ORDER_TRAFFICKER = 'ORDER_TRAFFICKER';
    const ORDER_TRAFFICKER_ID = 'ORDER_TRAFFICKER_ID';
    const ORDER_SECONDARY_TRAFFICKERS = 'ORDER_SECONDARY_TRAFFICKERS';
    const ORDER_SALESPERSON = 'ORDER_SALESPERSON';
    const ORDER_SECONDARY_SALESPEOPLE = 'ORDER_SECONDARY_SALESPEOPLE';
    const ORDER_LIFETIME_IMPRESSIONS = 'ORDER_LIFETIME_IMPRESSIONS';
    const ORDER_LIFETIME_CLICKS = 'ORDER_LIFETIME_CLICKS';
    const ORDER_BOOKED_CPM = 'ORDER_BOOKED_CPM';
    const ORDER_BOOKED_CPC = 'ORDER_BOOKED_CPC';
    const LINE_ITEM_START_DATE_TIME = 'LINE_ITEM_START_DATE_TIME';
    const LINE_ITEM_END_DATE_TIME = 'LINE_ITEM_END_DATE_TIME';
    const LINE_ITEM_EXTERNAL_ID = 'LINE_ITEM_EXTERNAL_ID';
    const LINE_ITEM_COST_TYPE = 'LINE_ITEM_COST_TYPE';
    const LINE_ITEM_COST_PER_UNIT = 'LINE_ITEM_COST_PER_UNIT';
    const LINE_ITEM_CURRENCY_CODE = 'LINE_ITEM_CURRENCY_CODE';
    const LINE_ITEM_GOAL_QUANTITY = 'LINE_ITEM_GOAL_QUANTITY';
    const LINE_ITEM_SPONSORSHIP_GOAL_PERCENTAGE = 'LINE_ITEM_SPONSORSHIP_GOAL_PERCENTAGE';
    const LINE_ITEM_LIFETIME_IMPRESSIONS = 'LINE_ITEM_LIFETIME_IMPRESSIONS';
    const LINE_ITEM_LIFETIME_CLICKS = 'LINE_ITEM_LIFETIME_CLICKS';
    const LINE_ITEM_PRIORITY = 'LINE_ITEM_PRIORITY';
    const CREATIVE_OR_CREATIVE_SET = 'CREATIVE_OR_CREATIVE_SET';
    const MASTER_COMPANION_TYPE = 'MASTER_COMPANION_TYPE';
    const LINE_ITEM_CONTRACTED_QUANTITY = 'LINE_ITEM_CONTRACTED_QUANTITY';
    const LINE_ITEM_DISCOUNT = 'LINE_ITEM_DISCOUNT';
    const LINE_ITEM_NON_CPD_BOOKED_REVENUE = 'LINE_ITEM_NON_CPD_BOOKED_REVENUE';
    const ADVERTISER_LABELS = 'ADVERTISER_LABELS';
    const ADVERTISER_LABEL_IDS = 'ADVERTISER_LABEL_IDS';
    const CREATIVE_CLICK_THROUGH_URL = 'CREATIVE_CLICK_THROUGH_URL';
    const CREATIVE_SSL_SCAN_RESULT = 'CREATIVE_SSL_SCAN_RESULT';
    const CREATIVE_SSL_COMPLIANCE_OVERRIDE = 'CREATIVE_SSL_COMPLIANCE_OVERRIDE';
    const LINE_ITEM_CREATIVE_START_DATE = 'LINE_ITEM_CREATIVE_START_DATE';
    const LINE_ITEM_CREATIVE_END_DATE = 'LINE_ITEM_CREATIVE_END_DATE';
    const PROPOSAL_START_DATE_TIME = 'PROPOSAL_START_DATE_TIME';
    const PROPOSAL_END_DATE_TIME = 'PROPOSAL_END_DATE_TIME';
    const PROPOSAL_CREATION_DATE_TIME = 'PROPOSAL_CREATION_DATE_TIME';
    const PROPOSAL_SOLD_DATE_TIME = 'PROPOSAL_SOLD_DATE_TIME';
    const PROPOSAL_IS_SOLD = 'PROPOSAL_IS_SOLD';
    const PROPOSAL_PROBABILITY_OF_CLOSE = 'PROPOSAL_PROBABILITY_OF_CLOSE';
    const PROPOSAL_STATUS = 'PROPOSAL_STATUS';
    const PROPOSAL_ARCHIVAL_STATUS = 'PROPOSAL_ARCHIVAL_STATUS';
    const PROPOSAL_CURRENCY = 'PROPOSAL_CURRENCY';
    const PROPOSAL_EXCHANGE_RATE = 'PROPOSAL_EXCHANGE_RATE';
    const PROPOSAL_AGENCY_COMMISSION_RATE = 'PROPOSAL_AGENCY_COMMISSION_RATE';
    const PROPOSAL_VAT_RATE = 'PROPOSAL_VAT_RATE';
    const PROPOSAL_DISCOUNT = 'PROPOSAL_DISCOUNT';
    const PROPOSAL_ADVERTISER_DISCOUNT = 'PROPOSAL_ADVERTISER_DISCOUNT';
    const PROPOSAL_ADVERTISER = 'PROPOSAL_ADVERTISER';
    const PROPOSAL_ADVERTISER_ID = 'PROPOSAL_ADVERTISER_ID';
    const PROPOSAL_AGENCIES = 'PROPOSAL_AGENCIES';
    const PROPOSAL_AGENCY_IDS = 'PROPOSAL_AGENCY_IDS';
    const PROPOSAL_PO_NUMBER = 'PROPOSAL_PO_NUMBER';
    const PROPOSAL_PRIMARY_SALESPERSON = 'PROPOSAL_PRIMARY_SALESPERSON';
    const PROPOSAL_SECONDARY_SALESPEOPLE = 'PROPOSAL_SECONDARY_SALESPEOPLE';
    const PROPOSAL_CREATOR = 'PROPOSAL_CREATOR';
    const PROPOSAL_SALES_PLANNERS = 'PROPOSAL_SALES_PLANNERS';
    const PROPOSAL_PRICING_MODEL = 'PROPOSAL_PRICING_MODEL';
    const PROPOSAL_BILLING_SOURCE = 'PROPOSAL_BILLING_SOURCE';
    const PROPOSAL_BILLING_CAP = 'PROPOSAL_BILLING_CAP';
    const PROPOSAL_BILLING_SCHEDULE = 'PROPOSAL_BILLING_SCHEDULE';
    const PROPOSAL_APPLIED_TEAM_NAMES = 'PROPOSAL_APPLIED_TEAM_NAMES';
    const PROPOSAL_APPROVAL_STAGE = 'PROPOSAL_APPROVAL_STAGE';
    const PROPOSAL_INVENTORY_RELEASE_DATE_TIME = 'PROPOSAL_INVENTORY_RELEASE_DATE_TIME';
    const PROPOSAL_LOCAL_BUDGET = 'PROPOSAL_LOCAL_BUDGET';
    const PROPOSAL_LOCAL_REMAINING_BUDGET = 'PROPOSAL_LOCAL_REMAINING_BUDGET';
    const PROPOSAL_FLAT_FEE = 'PROPOSAL_FLAT_FEE';
    const PROPOSAL_IS_PROGRAMMATIC = 'PROPOSAL_IS_PROGRAMMATIC';
    const PROPOSAL_LINE_ITEM_START_DATE_TIME = 'PROPOSAL_LINE_ITEM_START_DATE_TIME';
    const PROPOSAL_LINE_ITEM_END_DATE_TIME = 'PROPOSAL_LINE_ITEM_END_DATE_TIME';
    const PROPOSAL_LINE_ITEM_RATE_TYPE = 'PROPOSAL_LINE_ITEM_RATE_TYPE';
    const PROPOSAL_LINE_ITEM_RESERVATION_STATUS = 'PROPOSAL_LINE_ITEM_RESERVATION_STATUS';
    const PROPOSAL_LINE_ITEM_COST_PER_UNIT = 'PROPOSAL_LINE_ITEM_COST_PER_UNIT';
    const PROPOSAL_LINE_ITEM_LOCAL_COST_PER_UNIT = 'PROPOSAL_LINE_ITEM_LOCAL_COST_PER_UNIT';
    const PROPOSAL_LINE_ITEM_COST_PER_UNIT_GROSS = 'PROPOSAL_LINE_ITEM_COST_PER_UNIT_GROSS';
    const PROPOSAL_LINE_ITEM_LOCAL_COST_PER_UNIT_GROSS = 'PROPOSAL_LINE_ITEM_LOCAL_COST_PER_UNIT_GROSS';
    const PROPOSAL_LINE_ITEM_TYPE_AND_PRIORITY = 'PROPOSAL_LINE_ITEM_TYPE_AND_PRIORITY';
    const PROPOSAL_LINE_ITEM_SIZE = 'PROPOSAL_LINE_ITEM_SIZE';
    const PROPOSAL_LINE_ITEM_ARCHIVAL_STATUS = 'PROPOSAL_LINE_ITEM_ARCHIVAL_STATUS';
    const PROPOSAL_LINE_ITEM_PRODUCT_ADJUSTMENT = 'PROPOSAL_LINE_ITEM_PRODUCT_ADJUSTMENT';
    const PROPOSAL_LINE_ITEM_BUFFER = 'PROPOSAL_LINE_ITEM_BUFFER';
    const PROPOSAL_LINE_ITEM_LISTING_RATE_NET = 'PROPOSAL_LINE_ITEM_LISTING_RATE_NET';
    const PROPOSAL_LINE_ITEM_BILLING_SOURCE = 'PROPOSAL_LINE_ITEM_BILLING_SOURCE';
    const PROPOSAL_LINE_ITEM_BILLING_CAP = 'PROPOSAL_LINE_ITEM_BILLING_CAP';
    const PROPOSAL_LINE_ITEM_BILLING_SCHEDULE = 'PROPOSAL_LINE_ITEM_BILLING_SCHEDULE';
    const PROPOSAL_LINE_ITEM_GOAL_PERCENTAGE = 'PROPOSAL_LINE_ITEM_GOAL_PERCENTAGE';
    const PROPOSAL_LINE_ITEM_COST_ADJUSTMENT = 'PROPOSAL_LINE_ITEM_COST_ADJUSTMENT';
    const PROPOSAL_LINE_ITEM_COMMENTS = 'PROPOSAL_LINE_ITEM_COMMENTS';
    const PROPOSAL_LINE_ITEM_RECONCILIATION_STATUS = 'PROPOSAL_LINE_ITEM_RECONCILIATION_STATUS';
    const PROPOSAL_LINE_ITEM_LAST_RECONCILIATION_DATE_TIME = 'PROPOSAL_LINE_ITEM_LAST_RECONCILIATION_DATE_TIME';
    const PROPOSAL_LINE_ITEM_FLAT_FEE = 'PROPOSAL_LINE_ITEM_FLAT_FEE';
    const PRODUCT_PACKAGE_ITEM_ARCHIVAL_STATUS = 'PRODUCT_PACKAGE_ITEM_ARCHIVAL_STATUS';
    const PRODUCT_TEMPLATE_RATE_TYPE = 'PRODUCT_TEMPLATE_RATE_TYPE';
    const PRODUCT_TEMPLATE_STATUS = 'PRODUCT_TEMPLATE_STATUS';
    const PRODUCT_TEMPLATE_TYPE_AND_PRIORITY = 'PRODUCT_TEMPLATE_TYPE_AND_PRIORITY';
    const PRODUCT_TEMPLATE_PRODUCT_TYPE = 'PRODUCT_TEMPLATE_PRODUCT_TYPE';
    const PRODUCT_TEMPLATE_DESCRIPTION = 'PRODUCT_TEMPLATE_DESCRIPTION';
    const PRODUCT_PRODUCT_TEMPLATE_NAME = 'PRODUCT_PRODUCT_TEMPLATE_NAME';
    const PRODUCT_RATE_TYPE = 'PRODUCT_RATE_TYPE';
    const PRODUCT_STATUS = 'PRODUCT_STATUS';
    const PRODUCT_TYPE_AND_PRIORITY = 'PRODUCT_TYPE_AND_PRIORITY';
    const PRODUCT_PRODUCT_TYPE = 'PRODUCT_PRODUCT_TYPE';
    const PRODUCT_NOTES = 'PRODUCT_NOTES';
    const PRODUCT_INVENTORY_SIZES = 'PRODUCT_INVENTORY_SIZES';
    const PRODUCT_RATE = 'PRODUCT_RATE';
    const PACKAGED_PRODUCT_RATE = 'PACKAGED_PRODUCT_RATE';
    const PROPOSAL_AGENCY_TYPE = 'PROPOSAL_AGENCY_TYPE';
    const PROPOSAL_AGENCY_CREDIT_STATUS = 'PROPOSAL_AGENCY_CREDIT_STATUS';
    const PROPOSAL_AGENCY_EXTERNAL_ID = 'PROPOSAL_AGENCY_EXTERNAL_ID';
    const PROPOSAL_AGENCY_COMMENT = 'PROPOSAL_AGENCY_COMMENT';
    const SALESPEOPLE_PROPOSAL_CONTRIBUTION = 'SALESPEOPLE_PROPOSAL_CONTRIBUTION';
    const SALESPERSON_PROPOSAL_CONTRIBUTION = 'SALESPERSON_PROPOSAL_CONTRIBUTION';
    const PRODUCT_PACKAGE_NOTES = 'PRODUCT_PACKAGE_NOTES';
    const PRODUCT_PACKAGE_ITEMS = 'PRODUCT_PACKAGE_ITEMS';
    const PRODUCT_PACKAGE_STATUS = 'PRODUCT_PACKAGE_STATUS';
    const PACKAGE_COMMENTS = 'PACKAGE_COMMENTS';
    const PACKAGE_START_DATE_TIME = 'PACKAGE_START_DATE_TIME';
    const PACKAGE_END_DATE_TIME = 'PACKAGE_END_DATE_TIME';
    const CONTENT_CMS_NAME = 'CONTENT_CMS_NAME';
    const CONTENT_CMS_VIDEO_ID = 'CONTENT_CMS_VIDEO_ID';
    const AD_UNIT_CODE = 'AD_UNIT_CODE';


}

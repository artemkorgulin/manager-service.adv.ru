<?php

namespace Google\AdsApi\Dfp\v201711;


/**
 * This file was generated from WSDL. DO NOT EDIT.
 */
class ProductTemplateErrorReason
{
    const INVALID_FEATURE_EXPANDED_EXCLUSIVE = 'INVALID_FEATURE_EXPANDED_EXCLUSIVE';
    const INVALID_EXPANDED_FEATURE_DEFAULT_NOT_TARGETED = 'INVALID_EXPANDED_FEATURE_DEFAULT_NOT_TARGETED';
    const INVALID_EXPANDED_FEATURE_DEFAULT_LOCKED = 'INVALID_EXPANDED_FEATURE_DEFAULT_LOCKED';
    const INVALID_EXPANDED_FEATURE_VALUE_TARGETED = 'INVALID_EXPANDED_FEATURE_VALUE_TARGETED';
    const INVALID_EXPANDED_FEATURE_VALUE_LOCKED = 'INVALID_EXPANDED_FEATURE_VALUE_LOCKED';
    const INVALID_FEATURE_TYPE = 'INVALID_FEATURE_TYPE';
    const INVALID_ROADBLOCKING_TYPE = 'INVALID_ROADBLOCKING_TYPE';
    const INVALID_DELIVERY_RATE_TYPE = 'INVALID_DELIVERY_RATE_TYPE';
    const INVALID_CREATIVE_ROTATION_TYPE = 'INVALID_CREATIVE_ROTATION_TYPE';
    const INVALID_COMPANION_DELIVERY_OPTION = 'INVALID_COMPANION_DELIVERY_OPTION';
    const INVALID_TARGETING = 'INVALID_TARGETING';
    const INVALID_FREQUENCY_CAPS = 'INVALID_FREQUENCY_CAPS';
    const INVALID_TECHNOLOGY_INCLUDE_EXCLUDE = 'INVALID_TECHNOLOGY_INCLUDE_EXCLUDE';
    const INVALID_EXPANDED_PRODUCT_COUNT = 'INVALID_EXPANDED_PRODUCT_COUNT';
    const INVALID_TARGET_PLATFORM = 'INVALID_TARGET_PLATFORM';
    const INVALID_NON_TARGETING_FEATURE = 'INVALID_NON_TARGETING_FEATURE';
    const INVALID_FEATURE_CARDINALITY_AT_LEAST_ONE = 'INVALID_FEATURE_CARDINALITY_AT_LEAST_ONE';
    const INVALID_FEATURE_CARDINALITY_AT_MOST_ONE = 'INVALID_FEATURE_CARDINALITY_AT_MOST_ONE';
    const INVALID_FEATURE_CARDINALITY_EXACTLY_ONE = 'INVALID_FEATURE_CARDINALITY_EXACTLY_ONE';
    const INVALID_FEATURE_FOR_OFFLINE = 'INVALID_FEATURE_FOR_OFFLINE';
    const INVALID_RATE_TYPE_FOR_OFFLINE = 'INVALID_RATE_TYPE_FOR_OFFLINE';
    const INVALID_RATE_TYPE_FOR_DFP = 'INVALID_RATE_TYPE_FOR_DFP';
    const INVALID_RATE_TYPE_FOR_NON_DFP = 'INVALID_RATE_TYPE_FOR_NON_DFP';
    const INVALID_VALUES_FOR_CLICK_TRACKING_LINE_ITEM_TYPE = 'INVALID_VALUES_FOR_CLICK_TRACKING_LINE_ITEM_TYPE';
    const INVALID_SEGMENTATION_OR_TARGETING_FOR_CLICK_TRACKING_LINE_ITEM_TYPE = 'INVALID_SEGMENTATION_OR_TARGETING_FOR_CLICK_TRACKING_LINE_ITEM_TYPE';
    const INVALID_LINE_ITEM_PRIORITY = 'INVALID_LINE_ITEM_PRIORITY';
    const INVALID_LINE_ITEM_TYPE = 'INVALID_LINE_ITEM_TYPE';
    const INVALID_ENVIRONMENT_TYPE = 'INVALID_ENVIRONMENT_TYPE';
    const DUPLICATED_PLACEHOLDER_IN_NAMEMACRO = 'DUPLICATED_PLACEHOLDER_IN_NAMEMACRO';
    const INVALID_EXPANDED_FEATURE_IN_NON_EXPANDABLE_AFFINITY = 'INVALID_EXPANDED_FEATURE_IN_NON_EXPANDABLE_AFFINITY';
    const INVALID_FEATURE_DEFAULT_TARGET_TYPE = 'INVALID_FEATURE_DEFAULT_TARGET_TYPE';
    const INVALID_FEATURE_VALUE_TARGET_TYPE = 'INVALID_FEATURE_VALUE_TARGET_TYPE';
    const INVALID_FEATURE_AND_VALUE_LOCK_EXCLUSIVE = 'INVALID_FEATURE_AND_VALUE_LOCK_EXCLUSIVE';
    const INVALID_CREATIVE_PLACEHOLDER = 'INVALID_CREATIVE_PLACEHOLDER';
    const DUPLICATED_FEATURE = 'DUPLICATED_FEATURE';
    const DUPLICATED_CUSTOM_TARGETING_KEY = 'DUPLICATED_CUSTOM_TARGETING_KEY';
    const DUPLICATED_CUSTOM_TARGETING_VALUE = 'DUPLICATED_CUSTOM_TARGETING_VALUE';
    const INVALID_CUSTOM_TARGETING_KEY_ID = 'INVALID_CUSTOM_TARGETING_KEY_ID';
    const INVALID_CUSTOM_TARGETING_VALUE_ID = 'INVALID_CUSTOM_TARGETING_VALUE_ID';
    const MISSING_CUSTOM_TARGETING_VALUES = 'MISSING_CUSTOM_TARGETING_VALUES';
    const LOCATION_CANNOT_BE_TARGETED_IF_PARENT_IS_TARGETED = 'LOCATION_CANNOT_BE_TARGETED_IF_PARENT_IS_TARGETED';
    const LOCATION_CANNOT_BE_EXCLUDED_IF_PARENT_IS_EXCLUDED = 'LOCATION_CANNOT_BE_EXCLUDED_IF_PARENT_IS_EXCLUDED';
    const LOCATION_CANNOT_BE_EXCLUDED_DIRECTLY_WHEN_HAVE_TARGETED_LOCATION = 'LOCATION_CANNOT_BE_EXCLUDED_DIRECTLY_WHEN_HAVE_TARGETED_LOCATION';
    const CUSTOMIZABLE_CUSTOM_KEY_CANNOT_BE_SEGMENTED = 'CUSTOMIZABLE_CUSTOM_KEY_CANNOT_BE_SEGMENTED';
    const CUSTOM_KEY_USED_IN_TARGETING_CANNOT_BE_SEGMENTED = 'CUSTOM_KEY_USED_IN_TARGETING_CANNOT_BE_SEGMENTED';
    const MISSING_EXPANDED_FEATURE_PLACEHOLDER_IN_NAMEMACRO = 'MISSING_EXPANDED_FEATURE_PLACEHOLDER_IN_NAMEMACRO';
    const MISSING_FEATURE_VALUE_OF_NAMEMACRO_PLACEHOLDER = 'MISSING_FEATURE_VALUE_OF_NAMEMACRO_PLACEHOLDER';
    const MISSING_FEATURE_OF_NAMEMACRO_PLACEHOLDER = 'MISSING_FEATURE_OF_NAMEMACRO_PLACEHOLDER';
    const MISSING_SUBTYPE_FOR_CUSTOM_TARGETING = 'MISSING_SUBTYPE_FOR_CUSTOM_TARGETING';
    const COMPANION_NOT_ALLOWED = 'COMPANION_NOT_ALLOWED';
    const MISSING_COMPANION = 'MISSING_COMPANION';
    const DUPLICATED_MASTER_SIZE = 'DUPLICATED_MASTER_SIZE';
    const CANNOT_HAVE_CREATIVE_TEMPLATE = 'CANNOT_HAVE_CREATIVE_TEMPLATE';
    const NATIVE_CREATIVE_TEMPLATE_REQUIRED = 'NATIVE_CREATIVE_TEMPLATE_REQUIRED';
    const CANNOT_INCLUDE_NATIVE_PLACEHOLDER_WITHOUT_TEMPLATE_ID = 'CANNOT_INCLUDE_NATIVE_PLACEHOLDER_WITHOUT_TEMPLATE_ID';
    const CANNOT_MODIFY_READONLY_FEATURE = 'CANNOT_MODIFY_READONLY_FEATURE';
    const CANNOT_MODIFY_PRODUCT_TYPE = 'CANNOT_MODIFY_PRODUCT_TYPE';
    const CANNOT_ADD_SEGMENTATION = 'CANNOT_ADD_SEGMENTATION';
    const CANNOT_REMOVE_SEGMENTATION = 'CANNOT_REMOVE_SEGMENTATION';
    const CANNOT_REMOVE_VALUE_FROM_SEGMENTATION = 'CANNOT_REMOVE_VALUE_FROM_SEGMENTATION';
    const CANNOT_ADD_FEATURE_VALUE_FOR_CUSTOM_TARGETING = 'CANNOT_ADD_FEATURE_VALUE_FOR_CUSTOM_TARGETING';
    const CANNOT_MODIFY_BUILTIN_TARGETING_FEATURE = 'CANNOT_MODIFY_BUILTIN_TARGETING_FEATURE';
    const CANNOT_UPDATE_ARCHIVED_PRODUCT_TEMPLATE = 'CANNOT_UPDATE_ARCHIVED_PRODUCT_TEMPLATE';
    const INVALID_VIDEO_POSITION_VALUE_FOR_LINE_ITEM_TYPE = 'INVALID_VIDEO_POSITION_VALUE_FOR_LINE_ITEM_TYPE';
    const UNKNOWN = 'UNKNOWN';


}

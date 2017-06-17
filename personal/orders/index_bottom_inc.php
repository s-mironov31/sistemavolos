<?$_REQUEST["show_all"]="Y";?>
<?$APPLICATION->IncludeComponent(
	"bitrix:sale.personal.order.list", 
	".default", 
	array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"CACHE_GROUPS" => "N",
		"PATH_TO_DETAIL" => "",
		"PATH_TO_COPY" => "",
		"PATH_TO_CANCEL" => "",
		"PATH_TO_BASKET" => "",
		"ORDERS_PER_PAGE" => "100",
		"ID" => $ID,
		"SET_TITLE" => "N",
		"SAVE_IN_SESSION" => "Y",
		"NAV_TEMPLATE" => "",
		"HISTORIC_STATUSES" => array(
		),
		"STATUS_COLOR_N" => "green",
		"STATUS_COLOR_F" => "green",
		"STATUS_COLOR_PSEUDO_CANCELLED" => "green"
	),
	false
);?>
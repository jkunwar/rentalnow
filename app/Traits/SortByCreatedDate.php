<?php

	namespace App\Traits;

	trait SortByCreatedDate {

		public static function compare($a, $b) {
	        return $a->message['created_at'] < $b->message['created_at'];
		}

		public function sortContacts($contactsArray) {
			$outerContactsArray = array();
	    	usort($contactsArray, "self::compare");
	    	$outerContactsArray = array_merge($outerContactsArray, $contactsArray);
		    return $outerContactsArray;
		}
	}
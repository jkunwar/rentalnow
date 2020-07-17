<?php

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$countries = [
		    [
		        "name" => "Afghanistan",
		        "alpha2Code" => "AF",
		        "alpha3Code" => "AFG",
		        "callingCodes" => "93",
		        "numericCode" => "004"
		    ],
		    [
		        "name" => "Åland Islands",
		        "alpha2Code" => "AX",
		        "alpha3Code" => "ALA",
		        "callingCodes" => "358",
		        "numericCode" => "248"
		    ],
		    [
		        "name" => "Albania",
		        "alpha2Code" => "AL",
		        "alpha3Code" => "ALB",
		        "callingCodes" => "355",
		        "numericCode" => "008"
		    ],
		    [
		        "name" => "Algeria",
		        "alpha2Code" => "DZ",
		        "alpha3Code" => "DZA",
		        "callingCodes" => "213",
		        "numericCode" => "012"
		    ],
		    [
		        "name" => "American Samoa",
		        "alpha2Code" => "AS",
		        "alpha3Code" => "ASM",
		        "callingCodes" => "1684",
		        "numericCode" => "016"
		    ],
		    [
		        "name" => "Andorra",
		        "alpha2Code" => "AD",
		        "alpha3Code" => "AND",
		        "callingCodes" => "376",
		        "numericCode" => "020"
		    ],
		    [
		        "name" => "Angola",
		        "alpha2Code" => "AO",
		        "alpha3Code" => "AGO",
		        "callingCodes" => "244",
		        "numericCode" => "024"
		    ],
		    [
		        "name" => "Anguilla",
		        "alpha2Code" => "AI",
		        "alpha3Code" => "AIA",
		        "callingCodes" => "1264",
		        "numericCode" => "660"
		    ],
		    [
		        "name" => "Antarctica",
		        "alpha2Code" => "AQ",
		        "alpha3Code" => "ATA",
		        "callingCodes" => "672",
		        "numericCode" => "010"
		    ],
		    [
		        "name" => "Antigua and Barbuda",
		        "alpha2Code" => "AG",
		        "alpha3Code" => "ATG",
		        "callingCodes" => "1268",
		        "numericCode" => "028"
		    ],
		    [
		        "name" => "Argentina",
		        "alpha2Code" => "AR",
		        "alpha3Code" => "ARG",
		        "callingCodes" => "54",
		        "numericCode" => "032"
		    ],
		    [
		        "name" => "Armenia",
		        "alpha2Code" => "AM",
		        "alpha3Code" => "ARM",
		        "callingCodes" => "374",
		        "numericCode" => "051"
		    ],
		    [
		        "name" => "Aruba",
		        "alpha2Code" => "AW",
		        "alpha3Code" => "ABW",
		        "callingCodes" => "297",
		        "numericCode" => "533"
		    ],
		    [
		        "name" => "Australia",
		        "alpha2Code" => "AU",
		        "alpha3Code" => "AUS",
		        "callingCodes" => "61",
		        "numericCode" => "036"
		    ],
		    [
		        "name" => "Austria",
		        "alpha2Code" => "AT",
		        "alpha3Code" => "AUT",
		        "callingCodes" => "43",
		        "numericCode" => "040"
		    ],
		    [
		        "name" => "Azerbaijan",
		        "alpha2Code" => "AZ",
		        "alpha3Code" => "AZE",
		        "callingCodes" => "994",
		        "numericCode" => "031"
		    ],
		    [
		        "name" => "Bahamas",
		        "alpha2Code" => "BS",
		        "alpha3Code" => "BHS",
		        "callingCodes" => "1242",
		        "numericCode" => "044"
		    ],
		    [
		        "name" => "Bahrain",
		        "alpha2Code" => "BH",
		        "alpha3Code" => "BHR",
		        "callingCodes" => "973",
		        "numericCode" => "048"
		    ],
		    [
		        "name" => "Bangladesh",
		        "alpha2Code" => "BD",
		        "alpha3Code" => "BGD",
		        "callingCodes" => "880",
		        "numericCode" => "050"
		    ],
		    [
		        "name" => "Barbados",
		        "alpha2Code" => "BB",
		        "alpha3Code" => "BRB",
		        "callingCodes" => "1246",
		        "numericCode" => "052"
		    ],
		    [
		        "name" => "Belarus",
		        "alpha2Code" => "BY",
		        "alpha3Code" => "BLR",
		        "callingCodes" => "375",
		        "numericCode" => "112"
		    ],
		    [
		        "name" => "Belgium",
		        "alpha2Code" => "BE",
		        "alpha3Code" => "BEL",
		        "callingCodes" => "32",
		        "numericCode" => "056"
		    ],
		    [
		        "name" => "Belize",
		        "alpha2Code" => "BZ",
		        "alpha3Code" => "BLZ",
		        "callingCodes" => "501",
		        "numericCode" => "084"
		    ],
		    [
		        "name" => "Benin",
		        "alpha2Code" => "BJ",
		        "alpha3Code" => "BEN",
		        "callingCodes" => "229",
		        "numericCode" => "204"
		    ],
		    [
		        "name" => "Bermuda",
		        "alpha2Code" => "BM",
		        "alpha3Code" => "BMU",
		        "callingCodes" => "1441",
		        "numericCode" => "060"
		    ],
		    [
		        "name" => "Bhutan",
		        "alpha2Code" => "BT",
		        "alpha3Code" => "BTN",
		        "callingCodes" => "975",
		        "numericCode" => "064"
		    ],
		    [
		        "name" => "Bolivia (Plurinational State of)",
		        "alpha2Code" => "BO",
		        "alpha3Code" => "BOL",
		        "callingCodes" => "591",
		        "numericCode" => "068"
		    ],
		    [
		        "name" => "Bonaire, Sint Eustatius and Saba",
		        "alpha2Code" => "BQ",
		        "alpha3Code" => "BES",
		        "callingCodes" => "5997",
		        "numericCode" => "535"
		    ],
		    [
		        "name" => "Bosnia and Herzegovina",
		        "alpha2Code" => "BA",
		        "alpha3Code" => "BIH",
		        "callingCodes" => "387",
		        "numericCode" => "070"
		    ],
		    [
		        "name" => "Botswana",
		        "alpha2Code" => "BW",
		        "alpha3Code" => "BWA",
		        "callingCodes" => "267",
		        "numericCode" => "072"
		    ],
		    [
		        "name" => "Bouvet Island",
		        "alpha2Code" => "BV",
		        "alpha3Code" => "BVT",
		        "callingCodes" => "",
		        "numericCode" => "074"
		    ],
		    [
		        "name" => "Brazil",
		        "alpha2Code" => "BR",
		        "alpha3Code" => "BRA",
		        "callingCodes" => "55",
		        "numericCode" => "076"
		    ],
		    [
		        "name" => "British Indian Ocean Territory",
		        "alpha2Code" => "IO",
		        "alpha3Code" => "IOT",
		        "callingCodes" => "246",
		        "numericCode" => "086"
		    ],
		    [
		        "name" => "United States Minor Outlying Islands",
		        "alpha2Code" => "UM",
		        "alpha3Code" => "UMI",
		        "callingCodes" => "",
		        "numericCode" => "581"
		    ],
		    [
		        "name" => "Virgin Islands (British)",
		        "alpha2Code" => "VG",
		        "alpha3Code" => "VGB",
		        "callingCodes" => "1284",
		        "numericCode" => "092"
		    ],
		    [
		        "name" => "Virgin Islands (U.S.)",
		        "alpha2Code" => "VI",
		        "alpha3Code" => "VIR",
		        "callingCodes" => "1 340",
		        "numericCode" => "850"
		    ],
		    [
		        "name" => "Brunei Darussalam",
		        "alpha2Code" => "BN",
		        "alpha3Code" => "BRN",
		        "callingCodes" => "673",
		        "numericCode" => "096"
		    ],
		    [
		        "name" => "Bulgaria",
		        "alpha2Code" => "BG",
		        "alpha3Code" => "BGR",
		        "callingCodes" => "359",
		        "numericCode" => "100"
		    ],
		    [
		        "name" => "Burkina Faso",
		        "alpha2Code" => "BF",
		        "alpha3Code" => "BFA",
		        "callingCodes" => "226",
		        "numericCode" => "854"
		    ],
		    [
		        "name" => "Burundi",
		        "alpha2Code" => "BI",
		        "alpha3Code" => "BDI",
		        "callingCodes" => "257",
		        "numericCode" => "108"
		    ],
		    [
		        "name" => "Cambodia",
		        "alpha2Code" => "KH",
		        "alpha3Code" => "KHM",
		        "callingCodes" => "855",
		        "numericCode" => "116"
		    ],
		    [
		        "name" => "Cameroon",
		        "alpha2Code" => "CM",
		        "alpha3Code" => "CMR",
		        "callingCodes" => "237",
		        "numericCode" => "120"
		    ],
		    [
		        "name" => "Canada",
		        "alpha2Code" => "CA",
		        "alpha3Code" => "CAN",
		        "callingCodes" => "1",
		        "numericCode" => "124"
		    ],
		    [
		        "name" => "Cabo Verde",
		        "alpha2Code" => "CV",
		        "alpha3Code" => "CPV",
		        "callingCodes" => "238",
		        "numericCode" => "132"
		    ],
		    [
		        "name" => "Cayman Islands",
		        "alpha2Code" => "KY",
		        "alpha3Code" => "CYM",
		        "callingCodes" => "1345",
		        "numericCode" => "136"
		    ],
		    [
		        "name" => "Central African Republic",
		        "alpha2Code" => "CF",
		        "alpha3Code" => "CAF",
		        "callingCodes" => "236",
		        "numericCode" => "140"
		    ],
		    [
		        "name" => "Chad",
		        "alpha2Code" => "TD",
		        "alpha3Code" => "TCD",
		        "callingCodes" => "235",
		        "numericCode" => "148"
		    ],
		    [
		        "name" => "Chile",
		        "alpha2Code" => "CL",
		        "alpha3Code" => "CHL",
		        "callingCodes" => "56",
		        "numericCode" => "152"
		    ],
		    [
		        "name" => "China",
		        "alpha2Code" => "CN",
		        "alpha3Code" => "CHN",
		        "callingCodes" => "86",
		        "numericCode" => "156"
		    ],
		    [
		        "name" => "Christmas Island",
		        "alpha2Code" => "CX",
		        "alpha3Code" => "CXR",
		        "callingCodes" => "61",
		        "numericCode" => "162"
		    ],
		    [
		        "name" => "Cocos (Keeling) Islands",
		        "alpha2Code" => "CC",
		        "alpha3Code" => "CCK",
		        "callingCodes" => "61",
		        "numericCode" => "166"
		    ],
		    [
		        "name" => "Colombia",
		        "alpha2Code" => "CO",
		        "alpha3Code" => "COL",
		        "callingCodes" => "57",
		        "numericCode" => "170"
		    ],
		    [
		        "name" => "Comoros",
		        "alpha2Code" => "KM",
		        "alpha3Code" => "COM",
		        "callingCodes" => "269",
		        "numericCode" => "174"
		    ],
		    [
		        "name" => "Congo",
		        "alpha2Code" => "CG",
		        "alpha3Code" => "COG",
		        "callingCodes" => "242",
		        "numericCode" => "178"
		    ],
		    [
		        "name" => "Congo (Democratic Republic of the)",
		        "alpha2Code" => "CD",
		        "alpha3Code" => "COD",
		        "callingCodes" => "243",
		        "numericCode" => "180"
		    ],
		    [
		        "name" => "Cook Islands",
		        "alpha2Code" => "CK",
		        "alpha3Code" => "COK",
		        "callingCodes" => "682",
		        "numericCode" => "184"
		    ],
		    [
		        "name" => "Costa Rica",
		        "alpha2Code" => "CR",
		        "alpha3Code" => "CRI",
		        "callingCodes" => "506",
		        "numericCode" => "188"
		    ],
		    [
		        "name" => "Croatia",
		        "alpha2Code" => "HR",
		        "alpha3Code" => "HRV",
		        "callingCodes" => "385",
		        "numericCode" => "191"
		    ],
		    [
		        "name" => "Cuba",
		        "alpha2Code" => "CU",
		        "alpha3Code" => "CUB",
		        "callingCodes" => "53",
		        "numericCode" => "192"
		    ],
		    [
		        "name" => "Curaçao",
		        "alpha2Code" => "CW",
		        "alpha3Code" => "CUW",
		        "callingCodes" => "599",
		        "numericCode" => "531"
		    ],
		    [
		        "name" => "Cyprus",
		        "alpha2Code" => "CY",
		        "alpha3Code" => "CYP",
		        "callingCodes" => "357",
		        "numericCode" => "196"
		    ],
		    [
		        "name" => "Czech Republic",
		        "alpha2Code" => "CZ",
		        "alpha3Code" => "CZE",
		        "callingCodes" => "420",
		        "numericCode" => "203"
		    ],
		    [
		        "name" => "Denmark",
		        "alpha2Code" => "DK",
		        "alpha3Code" => "DNK",
		        "callingCodes" => "45",
		        "numericCode" => "208"
		    ],
		    [
		        "name" => "Djibouti",
		        "alpha2Code" => "DJ",
		        "alpha3Code" => "DJI",
		        "callingCodes" => "253",
		        "numericCode" => "262"
		    ],
		    [
		        "name" => "Dominica",
		        "alpha2Code" => "DM",
		        "alpha3Code" => "DMA",
		        "callingCodes" => "1767",
		        "numericCode" => "212"
		    ],
		    [
		        "name" => "Dominican Republic",
		        "alpha2Code" => "DO",
		        "alpha3Code" => "DOM",
		        "callingCodes" => "1809",
		        "numericCode" => "214"
		    ],
		    [
		        "name" => "Ecuador",
		        "alpha2Code" => "EC",
		        "alpha3Code" => "ECU",
		        "callingCodes" => "593",
		        "numericCode" => "218"
		    ],
		    [
		        "name" => "Egypt",
		        "alpha2Code" => "EG",
		        "alpha3Code" => "EGY",
		        "callingCodes" => "20",
		        "numericCode" => "818"
		    ],
		    [
		        "name" => "El Salvador",
		        "alpha2Code" => "SV",
		        "alpha3Code" => "SLV",
		        "callingCodes" => "503",
		        "numericCode" => "222"
		    ],
		    [
		        "name" => "Equatorial Guinea",
		        "alpha2Code" => "GQ",
		        "alpha3Code" => "GNQ",
		        "callingCodes" => "240",
		        "numericCode" => "226"
		    ],
		    [
		        "name" => "Eritrea",
		        "alpha2Code" => "ER",
		        "alpha3Code" => "ERI",
		        "callingCodes" => "291",
		        "numericCode" => "232"
		    ],
		    [
		        "name" => "Estonia",
		        "alpha2Code" => "EE",
		        "alpha3Code" => "EST",
		        "callingCodes" => "372",
		        "numericCode" => "233"
		    ],
		    [
		        "name" => "Ethiopia",
		        "alpha2Code" => "ET",
		        "alpha3Code" => "ETH",
		        "callingCodes" => "251",
		        "numericCode" => "231"
		    ],
		    [
		        "name" => "Falkland Islands (Malvinas)",
		        "alpha2Code" => "FK",
		        "alpha3Code" => "FLK",
		        "callingCodes" => "500",
		        "numericCode" => "238"
		    ],
		    [
		        "name" => "Faroe Islands",
		        "alpha2Code" => "FO",
		        "alpha3Code" => "FRO",
		        "callingCodes" => "298",
		        "numericCode" => "234"
		    ],
		    [
		        "name" => "Fiji",
		        "alpha2Code" => "FJ",
		        "alpha3Code" => "FJI",
		        "callingCodes" => "679",
		        "numericCode" => "242"
		    ],
		    [
		        "name" => "Finland",
		        "alpha2Code" => "FI",
		        "alpha3Code" => "FIN",
		        "callingCodes" => "358",
		        "numericCode" => "246"
		    ],
		    [
		        "name" => "France",
		        "alpha2Code" => "FR",
		        "alpha3Code" => "FRA",
		        "callingCodes" => "33",
		        "numericCode" => "250"
		    ],
		    [
		        "name" => "French Guiana",
		        "alpha2Code" => "GF",
		        "alpha3Code" => "GUF",
		        "callingCodes" => "594",
		        "numericCode" => "254"
		    ],
		    [
		        "name" => "French Polynesia",
		        "alpha2Code" => "PF",
		        "alpha3Code" => "PYF",
		        "callingCodes" => "689",
		        "numericCode" => "258"
		    ],
		    [
		        "name" => "French Southern Territories",
		        "alpha2Code" => "TF",
		        "alpha3Code" => "ATF",
		        "callingCodes" => "",
		        "numericCode" => "260"
		    ],
		    [
		        "name" => "Gabon",
		        "alpha2Code" => "GA",
		        "alpha3Code" => "GAB",
		        "callingCodes" => "241",
		        "numericCode" => "266"
		    ],
		    [
		        "name" => "Gambia",
		        "alpha2Code" => "GM",
		        "alpha3Code" => "GMB",
		        "callingCodes" => "220",
		        "numericCode" => "270"
		    ],
		    [
		        "name" => "Georgia",
		        "alpha2Code" => "GE",
		        "alpha3Code" => "GEO",
		        "callingCodes" => "995",
		        "numericCode" => "268"
		    ],
		    [
		        "name" => "Germany",
		        "alpha2Code" => "DE",
		        "alpha3Code" => "DEU",
		        "callingCodes" => "49",
		        "numericCode" => "276"
		    ],
		    [
		        "name" => "Ghana",
		        "alpha2Code" => "GH",
		        "alpha3Code" => "GHA",
		        "callingCodes" => "233",
		        "numericCode" => "288"
		    ],
		    [
		        "name" => "Gibraltar",
		        "alpha2Code" => "GI",
		        "alpha3Code" => "GIB",
		        "callingCodes" => "350",
		        "numericCode" => "292"
		    ],
		    [
		        "name" => "Greece",
		        "alpha2Code" => "GR",
		        "alpha3Code" => "GRC",
		        "callingCodes" => "30",
		        "numericCode" => "300"
		    ],
		    [
		        "name" => "Greenland",
		        "alpha2Code" => "GL",
		        "alpha3Code" => "GRL",
		        "callingCodes" => "299",
		        "numericCode" => "304"
		    ],
		    [
		        "name" => "Grenada",
		        "alpha2Code" => "GD",
		        "alpha3Code" => "GRD",
		        "callingCodes" => "1473",
		        "numericCode" => "308"
		    ],
		    [
		        "name" => "Guadeloupe",
		        "alpha2Code" => "GP",
		        "alpha3Code" => "GLP",
		        "callingCodes" => "590",
		        "numericCode" => "312"
		    ],
		    [
		        "name" => "Guam",
		        "alpha2Code" => "GU",
		        "alpha3Code" => "GUM",
		        "callingCodes" => "1671",
		        "numericCode" => "316"
		    ],
		    [
		        "name" => "Guatemala",
		        "alpha2Code" => "GT",
		        "alpha3Code" => "GTM",
		        "callingCodes" => "502",
		        "numericCode" => "320"
		    ],
		    [
		        "name" => "Guernsey",
		        "alpha2Code" => "GG",
		        "alpha3Code" => "GGY",
		        "callingCodes" => "44",
		        "numericCode" => "831"
		    ],
		    [
		        "name" => "Guinea",
		        "alpha2Code" => "GN",
		        "alpha3Code" => "GIN",
		        "callingCodes" => "224",
		        "numericCode" => "324"
		    ],
		    [
		        "name" => "Guinea-Bissau",
		        "alpha2Code" => "GW",
		        "alpha3Code" => "GNB",
		        "callingCodes" => "245",
		        "numericCode" => "624"
		    ],
		    [
		        "name" => "Guyana",
		        "alpha2Code" => "GY",
		        "alpha3Code" => "GUY",
		        "callingCodes" => "592",
		        "numericCode" => "328"
		    ],
		    [
		        "name" => "Haiti",
		        "alpha2Code" => "HT",
		        "alpha3Code" => "HTI",
		        "callingCodes" => "509",
		        "numericCode" => "332"
		    ],
		    [
		        "name" => "Heard Island and McDonald Islands",
		        "alpha2Code" => "HM",
		        "alpha3Code" => "HMD",
		        "callingCodes" => "",
		        "numericCode" => "334"
		    ],
		    [
		        "name" => "Holy See",
		        "alpha2Code" => "VA",
		        "alpha3Code" => "VAT",
		        "callingCodes" => "379",
		        "numericCode" => "336"
		    ],
		    [
		        "name" => "Honduras",
		        "alpha2Code" => "HN",
		        "alpha3Code" => "HND",
		        "callingCodes" => "504",
		        "numericCode" => "340"
		    ],
		    [
		        "name" => "Hong Kong",
		        "alpha2Code" => "HK",
		        "alpha3Code" => "HKG",
		        "callingCodes" => "852",
		        "numericCode" => "344"
		    ],
		    [
		        "name" => "Hungary",
		        "alpha2Code" => "HU",
		        "alpha3Code" => "HUN",
		        "callingCodes" => "36",
		        "numericCode" => "348"
		    ],
		    [
		        "name" => "Iceland",
		        "alpha2Code" => "IS",
		        "alpha3Code" => "ISL",
		        "callingCodes" => "354",
		        "numericCode" => "352"
		    ],
		    [
		        "name" => "India",
		        "alpha2Code" => "IN",
		        "alpha3Code" => "IND",
		        "callingCodes" => "91",
		        "numericCode" => "356"
		    ],
		    [
		        "name" => "Indonesia",
		        "alpha2Code" => "ID",
		        "alpha3Code" => "IDN",
		        "callingCodes" => "62",
		        "numericCode" => "360"
		    ],
		    [
		        "name" => "Côte d'Ivoire",
		        "alpha2Code" => "CI",
		        "alpha3Code" => "CIV",
		        "callingCodes" => "225",
		        "numericCode" => "384"
		    ],
		    [
		        "name" => "Iran (Islamic Republic of)",
		        "alpha2Code" => "IR",
		        "alpha3Code" => "IRN",
		        "callingCodes" => "98",
		        "numericCode" => "364"
		    ],
		    [
		        "name" => "Iraq",
		        "alpha2Code" => "IQ",
		        "alpha3Code" => "IRQ",
		        "callingCodes" => "964",
		        "numericCode" => "368"
		    ],
		    [
		        "name" => "Ireland",
		        "alpha2Code" => "IE",
		        "alpha3Code" => "IRL",
		        "callingCodes" => "353",
		        "numericCode" => "372"
		    ],
		    [
		        "name" => "Isle of Man",
		        "alpha2Code" => "IM",
		        "alpha3Code" => "IMN",
		        "callingCodes" => "44",
		        "numericCode" => "833"
		    ],
		    [
		        "name" => "Israel",
		        "alpha2Code" => "IL",
		        "alpha3Code" => "ISR",
		        "callingCodes" => "972",
		        "numericCode" => "376"
		    ],
		    [
		        "name" => "Italy",
		        "alpha2Code" => "IT",
		        "alpha3Code" => "ITA",
		        "callingCodes" => "39",
		        "numericCode" => "380"
		    ],
		    [
		        "name" => "Jamaica",
		        "alpha2Code" => "JM",
		        "alpha3Code" => "JAM",
		        "callingCodes" => "1876",
		        "numericCode" => "388"
		    ],
		    [
		        "name" => "Japan",
		        "alpha2Code" => "JP",
		        "alpha3Code" => "JPN",
		        "callingCodes" => "81",
		        "numericCode" => "392"
		    ],
		    [
		        "name" => "Jersey",
		        "alpha2Code" => "JE",
		        "alpha3Code" => "JEY",
		        "callingCodes" => "44",
		        "numericCode" => "832"
		    ],
		    [
		        "name" => "Jordan",
		        "alpha2Code" => "JO",
		        "alpha3Code" => "JOR",
		        "callingCodes" => "962",
		        "numericCode" => "400"
		    ],
		    [
		        "name" => "Kazakhstan",
		        "alpha2Code" => "KZ",
		        "alpha3Code" => "KAZ",
		        "callingCodes" => "76",
		       	"numericCode" => "398"
		    ],
		    [
		        "name" => "Kenya",
		        "alpha2Code" => "KE",
		        "alpha3Code" => "KEN",
		        "callingCodes" => "254",
		        "numericCode" => "404"
		    ],
		    [
		        "name" => "Kiribati",
		        "alpha2Code" => "KI",
		        "alpha3Code" => "KIR",
		        "callingCodes" => "686",
		        "numericCode" => "296"
		    ],
		    [
		        "name" => "Kuwait",
		        "alpha2Code" => "KW",
		        "alpha3Code" => "KWT",
		        "callingCodes" => "965",
		        "numericCode" => "414"
		    ],
		    [
		        "name" => "Kyrgyzstan",
		        "alpha2Code" => "KG",
		        "alpha3Code" => "KGZ",
		        "callingCodes" => "996",
		        "numericCode" => "417"
		    ],
		    [
		        "name" => "Lao People's Democratic Republic",
		        "alpha2Code" => "LA",
		        "alpha3Code" => "LAO",
		        "callingCodes" => "856",
		        "numericCode" => "418"
		    ],
		    [
		        "name" => "Latvia",
		        "alpha2Code" => "LV",
		        "alpha3Code" => "LVA",
		        "callingCodes" => "371",
		        "numericCode" => "428"
		    ],
		    [
		        "name" => "Lebanon",
		        "alpha2Code" => "LB",
		        "alpha3Code" => "LBN",
		        "callingCodes" => "961",
		        "numericCode" => "422"
		    ],
		    [
		        "name" => "Lesotho",
		        "alpha2Code" => "LS",
		        "alpha3Code" => "LSO",
		        "callingCodes" => "266",
		        "numericCode" => "426"
		    ],
		    [
		        "name" => "Liberia",
		        "alpha2Code" => "LR",
		        "alpha3Code" => "LBR",
		        "callingCodes" => "231",
		        "numericCode" => "430"
		    ],
		    [
		        "name" => "Libya",
		        "alpha2Code" => "LY",
		        "alpha3Code" => "LBY",
		        "callingCodes" => "218",
		        "numericCode" => "434"
		    ],
		    [
		        "name" => "Liechtenstein",
		        "alpha2Code" => "LI",
		        "alpha3Code" => "LIE",
		        "callingCodes" => "423",
		        "numericCode" => "438"
		    ],
		    [
		        "name" => "Lithuania",
		        "alpha2Code" => "LT",
		        "alpha3Code" => "LTU",
		        "callingCodes" => "370",
		        "numericCode" => "440"
		    ],
		    [
		        "name" => "Luxembourg",
		        "alpha2Code" => "LU",
		        "alpha3Code" => "LUX",
		        "callingCodes" => "352",
		        "numericCode" => "442"
		    ],
		    [
		        "name" => "Macao",
		        "alpha2Code" => "MO",
		        "alpha3Code" => "MAC",
		        "callingCodes" => "853",
		        "numericCode" => "446"
		    ],
		    [
		        "name" => "Macedonia (the former Yugoslav Republic of)",
		        "alpha2Code" => "MK",
		        "alpha3Code" => "MKD",
		        "callingCodes" => "389",
		        "numericCode" => "807"
		    ],
		    [
		        "name" => "Madagascar",
		        "alpha2Code" => "MG",
		        "alpha3Code" => "MDG",
		        "callingCodes" => "261",
		        "numericCode" => "450"
		    ],
		    [
		        "name" => "Malawi",
		        "alpha2Code" => "MW",
		        "alpha3Code" => "MWI",
		        "callingCodes" => "265",
		        "numericCode" => "454"
		    ],
		    [
		        "name" => "Malaysia",
		        "alpha2Code" => "MY",
		        "alpha3Code" => "MYS",
		        "callingCodes" => "60",
		        "numericCode" => "458"
		    ],
		    [
		        "name" => "Maldives",
		        "alpha2Code" => "MV",
		        "alpha3Code" => "MDV",
		        "callingCodes" => "960",
		        "numericCode" => "462"
		    ],
		    [
		        "name" => "Mali",
		        "alpha2Code" => "ML",
		        "alpha3Code" => "MLI",
		        "callingCodes" => "223",
		        "numericCode" => "466"
		    ],
		    [
		        "name" => "Malta",
		        "alpha2Code" => "MT",
		        "alpha3Code" => "MLT",
		        "callingCodes" => "356",
		        "numericCode" => "470"
		    ],
		    [
		        "name" => "Marshall Islands",
		        "alpha2Code" => "MH",
		        "alpha3Code" => "MHL",
		        "callingCodes" => "692",
		        "numericCode" => "584"
		    ],
		    [
		        "name" => "Martinique",
		        "alpha2Code" => "MQ",
		        "alpha3Code" => "MTQ",
		        "callingCodes" => "596",
		        "numericCode" => "474"
		    ],
		    [
		        "name" => "Mauritania",
		        "alpha2Code" => "MR",
		        "alpha3Code" => "MRT",
		        "callingCodes" => "222",
		        "numericCode" => "478"
		    ],
		    [
		        "name" => "Mauritius",
		        "alpha2Code" => "MU",
		        "alpha3Code" => "MUS",
		        "callingCodes" => "230",
		        "numericCode" => "480"
		    ],
		    [
		        "name" => "Mayotte",
		        "alpha2Code" => "YT",
		        "alpha3Code" => "MYT",
		        "callingCodes" => "262",
		        "numericCode" => "175"
		    ],
		    [
		        "name" => "Mexico",
		        "alpha2Code" => "MX",
		        "alpha3Code" => "MEX",
		        "callingCodes" => "52",
		        "numericCode" => "484"
		    ],
		    [
		        "name" => "Micronesia (Federated States of)",
		        "alpha2Code" => "FM",
		        "alpha3Code" => "FSM",
		        "callingCodes" => "691",
		        "numericCode" => "583"
		    ],
		    [
		        "name" => "Moldova (Republic of)",
		        "alpha2Code" => "MD",
		        "alpha3Code" => "MDA",
		        "callingCodes" => "373",
		        "numericCode" => "498"
		    ],
		    [
		        "name" => "Monaco",
		        "alpha2Code" => "MC",
		        "alpha3Code" => "MCO",
		        "callingCodes" => "377",
		        "numericCode" => "492"
		    ],
		    [
		        "name" => "Mongolia",
		        "alpha2Code" => "MN",
		        "alpha3Code" => "MNG",
		        "callingCodes" => "976",
		        "numericCode" => "496"
		    ],
		    [
		        "name" => "Montenegro",
		        "alpha2Code" => "ME",
		        "alpha3Code" => "MNE",
		        "callingCodes" => "382",
		        "numericCode" => "499"
		    ],
		    [
		        "name" => "Montserrat",
		        "alpha2Code" => "MS",
		        "alpha3Code" => "MSR",
		        "callingCodes" => "1664",
		        "numericCode" => "500"
		    ],
		    [
		        "name" => "Morocco",
		        "alpha2Code" => "MA",
		        "alpha3Code" => "MAR",
		        "callingCodes" => "212",
		        "numericCode" => "504"
		    ],
		    [
		        "name" => "Mozambique",
		        "alpha2Code" => "MZ",
		        "alpha3Code" => "MOZ",
		        "callingCodes" => "258",
		        "numericCode" => "508"
		    ],
		    [
		        "name" => "Myanmar",
		        "alpha2Code" => "MM",
		        "alpha3Code" => "MMR",
		        "callingCodes" => "95",
		        "numericCode" => "104"
		    ],
		    [
		        "name" => "Namibia",
		        "alpha2Code" => "NA",
		        "alpha3Code" => "NAM",
		        "callingCodes" => "264",
		        "numericCode" => "516"
		    ],
		    [
		        "name" => "Nauru",
		        "alpha2Code" => "NR",
		        "alpha3Code" => "NRU",
		        "callingCodes" => "674",
		        "numericCode" => "520"
		    ],
		    [
		        "name" => "Nepal",
		        "alpha2Code" => "NP",
		        "alpha3Code" => "NPL",
		        "callingCodes" => "977",
		        "numericCode" => "524"
		    ],
		    [
		        "name" => "Netherlands",
		        "alpha2Code" => "NL",
		        "alpha3Code" => "NLD",
		        "callingCodes" => "31",
		        "numericCode" => "528"
		    ],
		    [
		        "name" => "New Caledonia",
		        "alpha2Code" => "NC",
		        "alpha3Code" => "NCL",
		        "callingCodes" => "687",
		        "numericCode" => "540"
		    ],
		    [
		        "name" => "New Zealand",
		        "alpha2Code" => "NZ",
		        "alpha3Code" => "NZL",
		        "callingCodes" => "64",
		        "numericCode" => "554"
		    ],
		    [
		        "name" => "Nicaragua",
		        "alpha2Code" => "NI",
		        "alpha3Code" => "NIC",
		        "callingCodes" => "505",
		        "numericCode" => "558"
		    ],
		    [
		        "name" => "Niger",
		        "alpha2Code" => "NE",
		        "alpha3Code" => "NER",
		        "callingCodes" => "227",
		        "numericCode" => "562"
		    ],
		    [
		        "name" => "Nigeria",
		        "alpha2Code" => "NG",
		        "alpha3Code" => "NGA",
		        "callingCodes" => "234",
		        "numericCode" => "566"
		    ],
		    [
		        "name" => "Niue",
		        "alpha2Code" => "NU",
		        "alpha3Code" => "NIU",
		        "callingCodes" => "683",
		        "numericCode" => "570"
		    ],
		    [
		        "name" => "Norfolk Island",
		        "alpha2Code" => "NF",
		        "alpha3Code" => "NFK",
		        "callingCodes" => "672",
		        "numericCode" => "574"
		    ],
		    [
		        "name" => "Korea (Democratic People's Republic of)",
		        "alpha2Code" => "KP",
		        "alpha3Code" => "PRK",
		        "callingCodes" => "850",
		        "numericCode" => "408"
		    ],
		    [
		        "name" => "Northern Mariana Islands",
		        "alpha2Code" => "MP",
		        "alpha3Code" => "MNP",
		        "callingCodes" => "1670",
		        "numericCode" => "580"
		    ],
		    [
		        "name" => "Norway",
		        "alpha2Code" => "NO",
		        "alpha3Code" => "NOR",
		        "callingCodes" => "47",
		        "numericCode" => "578"
		    ],
		    [
		        "name" => "Oman",
		        "alpha2Code" => "OM",
		        "alpha3Code" => "OMN",
		        "callingCodes" => "968",
		        "numericCode" => "512"
		    ],
		    [
		        "name" => "Pakistan",
		        "alpha2Code" => "PK",
		        "alpha3Code" => "PAK",
		        "callingCodes" => "92",
		        "numericCode" => "586"
		    ],
		    [
		        "name" => "Palau",
		        "alpha2Code" => "PW",
		        "alpha3Code" => "PLW",
		        "callingCodes" => "680",
		        "numericCode" => "585"
		    ],
		    [
		        "name" => "Palestine, State of",
		        "alpha2Code" => "PS",
		        "alpha3Code" => "PSE",
		        "callingCodes" => "970",
		        "numericCode" => "275"
		    ],
		    [
		        "name" => "Panama",
		        "alpha2Code" => "PA",
		        "alpha3Code" => "PAN",
		        "callingCodes" => "507",
		        "numericCode" => "591"
		    ],
		    [
		        "name" => "Papua New Guinea",
		        "alpha2Code" => "PG",
		        "alpha3Code" => "PNG",
		        "callingCodes" => "675",
		        "numericCode" => "598"
		    ],
		    [
		        "name" => "Paraguay",
		        "alpha2Code" => "PY",
		        "alpha3Code" => "PRY",
		        "callingCodes" => "595",
		        "numericCode" => "600"
		    ],
		    [
		        "name" => "Peru",
		        "alpha2Code" => "PE",
		        "alpha3Code" => "PER",
		        "callingCodes" => "51",
		        "numericCode" => "604"
		    ],
		    [
		        "name" => "Philippines",
		        "alpha2Code" => "PH",
		        "alpha3Code" => "PHL",
		        "callingCodes" => "63",
		        "numericCode" => "608"
		    ],
		    [
		        "name" => "Pitcairn",
		        "alpha2Code" => "PN",
		        "alpha3Code" => "PCN",
		        "callingCodes" => "64",
		        "numericCode" => "612"
		    ],
		    [
		        "name" => "Poland",
		        "alpha2Code" => "PL",
		        "alpha3Code" => "POL",
		        "callingCodes" => "48",
		        "numericCode" => "616"
		    ],
		    [
		        "name" => "Portugal",
		        "alpha2Code" => "PT",
		        "alpha3Code" => "PRT",
		        "callingCodes" => "351",
		        "numericCode" => "620"
		    ],
		    [
		        "name" => "Puerto Rico",
		        "alpha2Code" => "PR",
		        "alpha3Code" => "PRI",
		        "callingCodes" => "1787",
		    	"numericCode" => "630"
		    ],
		    [
		        "name" => "Qatar",
		        "alpha2Code" => "QA",
		        "alpha3Code" => "QAT",
		        "callingCodes" => "974",
		        "numericCode" => "634"
		    ],
		    [
		        "name" => "Republic of Kosovo",
		        "alpha2Code" => "XK",
		        "alpha3Code" => "KOS",
		        "callingCodes" => "383"
		    ],
		    [
		        "name" => "Réunion",
		        "alpha2Code" => "RE",
		        "alpha3Code" => "REU",
		        "callingCodes" => "262",
		        "numericCode" => "638"
		    ],
		    [
		        "name" => "Romania",
		        "alpha2Code" => "RO",
		        "alpha3Code" => "ROU",
		        "callingCodes" => "40",
		        "numericCode" => "642"
		    ],
		    [
		        "name" => "Russian Federation",
		        "alpha2Code" => "RU",
		        "alpha3Code" => "RUS",
		        "callingCodes" => "7",
		        "numericCode" => "643"
		    ],
		    [
		        "name" => "Rwanda",
		        "alpha2Code" => "RW",
		        "alpha3Code" => "RWA",
		        "callingCodes" => "250",
		        "numericCode" => "646"
		    ],
		    [
		        "name" => "Saint Barthélemy",
		        "alpha2Code" => "BL",
		        "alpha3Code" => "BLM",
		        "callingCodes" => "590",
		        "numericCode" => "652"
		    ],
		    [
		        "name" => "Saint Helena, Ascension and Tristan da Cunha",
		        "alpha2Code" => "SH",
		        "alpha3Code" => "SHN",
		        "callingCodes" => "290",
		        "numericCode" => "654"
		    ],
		    [
		        "name" => "Saint Kitts and Nevis",
		        "alpha2Code" => "KN",
		        "alpha3Code" => "KNA",
		        "callingCodes" => "1869",
		        "numericCode" => "659"
		    ],
		    [
		        "name" => "Saint Lucia",
		        "alpha2Code" => "LC",
		        "alpha3Code" => "LCA",
		        "callingCodes" => "1758",
		        "numericCode" => "662"
		    ],
		    [
		        "name" => "Saint Martin (French part)",
		        "alpha2Code" => "MF",
		        "alpha3Code" => "MAF",
		        "callingCodes" => "590",
		        "numericCode" => "663"
		    ],
		    [
		        "name" => "Saint Pierre and Miquelon",
		        "alpha2Code" => "PM",
		        "alpha3Code" => "SPM",
		        "callingCodes" => "508",
		        "numericCode" => "666"
		    ],
		    [
		        "name" => "Saint Vincent and the Grenadines",
		        "alpha2Code" => "VC",
		        "alpha3Code" => "VCT",
		        "callingCodes" => "1784",
		        "numericCode" => "670"
		    ],
		    [
		        "name" => "Samoa",
		        "alpha2Code" => "WS",
		        "alpha3Code" => "WSM",
		        "callingCodes" => "685",
		        "numericCode" => "882"
		    ],
		    [
		        "name" => "San Marino",
		        "alpha2Code" => "SM",
		        "alpha3Code" => "SMR",
		        "callingCodes" => "378",
		        "numericCode" => "674"
		    ],
		    [
		        "name" => "Sao Tome and Principe",
		        "alpha2Code" => "ST",
		        "alpha3Code" => "STP",
		        "callingCodes" => "239",
		        "numericCode" => "678"
		    ],
		    [
		        "name" => "Saudi Arabia",
		        "alpha2Code" => "SA",
		        "alpha3Code" => "SAU",
		        "callingCodes" => "966",
		        "numericCode" => "682"
		    ],
		    [
		        "name" => "Senegal",
		        "alpha2Code" => "SN",
		        "alpha3Code" => "SEN",
		        "callingCodes" => "221",
		        "numericCode" => "686"
		    ],
		    [
		        "name" => "Serbia",
		        "alpha2Code" => "RS",
		        "alpha3Code" => "SRB",
		        "callingCodes" => "381",
		        "numericCode" => "688"
		    ],
		    [
		        "name" => "Seychelles",
		        "alpha2Code" => "SC",
		        "alpha3Code" => "SYC",
		        "callingCodes" => "248",
		        "numericCode" => "690"
		    ],
		    [
		        "name" => "Sierra Leone",
		        "alpha2Code" => "SL",
		        "alpha3Code" => "SLE",
		        "callingCodes" => "232",
		        "numericCode" => "694"
		    ],
		    [
		        "name" => "Singapore",
		        "alpha2Code" => "SG",
		        "alpha3Code" => "SGP",
		        "callingCodes" => "65",
		        "numericCode" => "702"
		    ],
		    [
		        "name" => "Sint Maarten (Dutch part)",
		        "alpha2Code" => "SX",
		        "alpha3Code" => "SXM",
		        "callingCodes" => "1721",
		        "numericCode" => "534"
		    ],
		    [
		        "name" => "Slovakia",
		        "alpha2Code" => "SK",
		        "alpha3Code" => "SVK",
		        "callingCodes" => "421",
		        "numericCode" => "703"
		    ],
		    [
		        "name" => "Slovenia",
		        "alpha2Code" => "SI",
		        "alpha3Code" => "SVN",
		        "callingCodes" => "386",
		        "numericCode" => "705"
		    ],
		    [
		        "name" => "Solomon Islands",
		        "alpha2Code" => "SB",
		        "alpha3Code" => "SLB",
		        "callingCodes" => "677",
		        "numericCode" => "090"
		    ],
		    [
		        "name" => "Somalia",
		        "alpha2Code" => "SO",
		        "alpha3Code" => "SOM",
		        "callingCodes" => "252",
		        "numericCode" => "706"
		    ],
		    [
		        "name" => "South Africa",
		        "alpha2Code" => "ZA",
		        "alpha3Code" => "ZAF",
		        "callingCodes" => "27",
		        "numericCode" => "710"
		    ],
		    [
		        "name" => "South Georgia and the South Sandwich Islands",
		        "alpha2Code" => "GS",
		        "alpha3Code" => "SGS",
		        "callingCodes" => "500",
		        "numericCode" => "239"
		    ],
		    [
		        "name" => "Korea (Republic of)",
		        "alpha2Code" => "KR",
		        "alpha3Code" => "KOR",
		        "callingCodes" => "82",
		        "numericCode" => "410"
		    ],
		    [
		        "name" => "South Sudan",
		        "alpha2Code" => "SS",
		        "alpha3Code" => "SSD",
		        "callingCodes" => "211",
		        "numericCode" => "728"
		    ],
		    [
		        "name" => "Spain",
		        "alpha2Code" => "ES",
		        "alpha3Code" => "ESP",
		        "callingCodes" => "34",
		        "numericCode" => "724"
		    ],
		    [
		        "name" => "Sri Lanka",
		        "alpha2Code" => "LK",
		        "alpha3Code" => "LKA",
		        "callingCodes" => "94",
		        "numericCode" => "144"
		    ],
		    [
		        "name" => "Sudan",
		        "alpha2Code" => "SD",
		        "alpha3Code" => "SDN",
		        "callingCodes" => "249",
		        "numericCode" => "729"
		    ],
		    [
		        "name" => "Suriname",
		        "alpha2Code" => "SR",
		        "alpha3Code" => "SUR",
		        "callingCodes" => "597",
		        "numericCode" => "740"
		    ],
		    [
		        "name" => "Svalbard and Jan Mayen",
		        "alpha2Code" => "SJ",
		        "alpha3Code" => "SJM",
		        "callingCodes" => "4779",
		        "numericCode" => "744"
		    ],
		    [
		        "name" => "Swaziland",
		        "alpha2Code" => "SZ",
		        "alpha3Code" => "SWZ",
		        "callingCodes" => "268",
		        "numericCode" => "748"
		    ],
		    [
		        "name" => "Sweden",
		        "alpha2Code" => "SE",
		        "alpha3Code" => "SWE",
		        "callingCodes" => "46",
		        "numericCode" => "752"
		    ],
		    [
		        "name" => "Switzerland",
		        "alpha2Code" => "CH",
		        "alpha3Code" => "CHE",
		        "callingCodes" => "41",
		        "numericCode" => "756"
		    ],
		    [
		        "name" => "Syrian Arab Republic",
		        "alpha2Code" => "SY",
		        "alpha3Code" => "SYR",
		        "callingCodes" => "963",
		        "numericCode" => "760"
		    ],
		    [
		        "name" => "Taiwan",
		        "alpha2Code" => "TW",
		        "alpha3Code" => "TWN",
		        "callingCodes" => "886",
		        "numericCode" => "158"
		    ],
		    [
		        "name" => "Tajikistan",
		        "alpha2Code" => "TJ",
		        "alpha3Code" => "TJK",
		        "callingCodes" => "992",
		        "numericCode" => "762"
		    ],
		    [
		        "name" => "Tanzania, United Republic of",
		        "alpha2Code" => "TZ",
		        "alpha3Code" => "TZA",
		        "callingCodes" => "255",
		        "numericCode" => "834"
		    ],
		    [
		        "name" => "Thailand",
		        "alpha2Code" => "TH",
		        "alpha3Code" => "THA",
		        "callingCodes" => "66",
		        "numericCode" => "764"
		    ],
		    [
		        "name" => "Timor-Leste",
		        "alpha2Code" => "TL",
		        "alpha3Code" => "TLS",
		        "callingCodes" => "670",
		        "numericCode" => "626"
		    ],
		    [
		        "name" => "Togo",
		        "alpha2Code" => "TG",
		        "alpha3Code" => "TGO",
		        "callingCodes" => "228",
		        "numericCode" => "768"
		    ],
		    [
		        "name" => "Tokelau",
		        "alpha2Code" => "TK",
		        "alpha3Code" => "TKL",
		        "callingCodes" => "690",
		        "numericCode" => "772"
		    ],
		    [
		        "name" => "Tonga",
		        "alpha2Code" => "TO",
		        "alpha3Code" => "TON",
		        "callingCodes" => "676",
		        "numericCode" => "776"
		    ],
		    [
		        "name" => "Trinidad and Tobago",
		        "alpha2Code" => "TT",
		        "alpha3Code" => "TTO",
		        "callingCodes" => "1868",
		        "numericCode" => "780"
		    ],
		    [
		        "name" => "Tunisia",
		        "alpha2Code" => "TN",
		        "alpha3Code" => "TUN",
		        "callingCodes" => "216",
		        "numericCode" => "788"
		    ],
		    [
		        "name" => "Turkey",
		        "alpha2Code" => "TR",
		        "alpha3Code" => "TUR",
		        "callingCodes" => "90",
		        "numericCode" => "792"
		    ],
		    [
		        "name" => "Turkmenistan",
		        "alpha2Code" => "TM",
		        "alpha3Code" => "TKM",
		        "callingCodes" => "993",
		        "numericCode" => "795"
		    ],
		    [
		        "name" => "Turks and Caicos Islands",
		        "alpha2Code" => "TC",
		        "alpha3Code" => "TCA",
		        "callingCodes" => "1649",
		        "numericCode" => "796"
		    ],
		    [
		        "name" => "Tuvalu",
		        "alpha2Code" => "TV",
		        "alpha3Code" => "TUV",
		        "callingCodes" => "688",
		        "numericCode" => "798"
		    ],
		    [
		        "name" => "Uganda",
		        "alpha2Code" => "UG",
		        "alpha3Code" => "UGA",
		        "callingCodes" => "256",
		        "numericCode" => "800"
		    ],
		    [
		        "name" => "Ukraine",
		        "alpha2Code" => "UA",
		        "alpha3Code" => "UKR",
		        "callingCodes" => "380",
		        "numericCode" => "804"
		    ],
		    [
		        "name" => "United Arab Emirates",
		        "alpha2Code" => "AE",
		        "alpha3Code" => "ARE",
		        "callingCodes" => "971",
		        "numericCode" => "784"
		    ],
		    [
		        "name" => "United Kingdom of Great Britain and Northern Ireland",
		        "alpha2Code" => "GB",
		        "alpha3Code" => "GBR",
		        "callingCodes" => "44",
		        "numericCode" => "826"
		    ],
		    [
		        "name" => "United States of America",
		        "alpha2Code" => "US",
		        "alpha3Code" => "USA",
		        "callingCodes" => "1",
		        "numericCode" => "840"
		    ],
		    [
		        "name" => "Uruguay",
		        "alpha2Code" => "UY",
		        "alpha3Code" => "URY",
		        "callingCodes" => "598",
		        "numericCode" => "858"
		    ],
		    [
		        "name" => "Uzbekistan",
		        "alpha2Code" => "UZ",
		        "alpha3Code" => "UZB",
		        "callingCodes" => "998",
		        "numericCode" => "860"
		    ],
		    [
		        "name" => "Vanuatu",
		        "alpha2Code" => "VU",
		        "alpha3Code" => "VUT",
		        "callingCodes" => "678",
		        "numericCode" => "548"
		    ],
		    [
		        "name" => "Venezuela (Bolivarian Republic of)",
		        "alpha2Code" => "VE",
		        "alpha3Code" => "VEN",
		        "callingCodes" => "58",
		        "numericCode" => "862"
		    ],
		    [
		        "name" => "Viet Nam",
		        "alpha2Code" => "VN",
		        "alpha3Code" => "VNM",
		        "callingCodes" => "84",
		        "numericCode" => "704"
		    ],
		    [
		        "name" => "Wallis and Futuna",
		        "alpha2Code" => "WF",
		        "alpha3Code" => "WLF",
		        "callingCodes" => "681",
		        "numericCode" => "876"
		    ],
		    [
		        "name" => "Western Sahara",
		        "alpha2Code" => "EH",
		        "alpha3Code" => "ESH",
		        "callingCodes" => "212",
		        "numericCode" => "732"
		    ],
		    [
		        "name" => "Yemen",
		        "alpha2Code" => "YE",
		        "alpha3Code" => "YEM",
		        "callingCodes" => "967",
		        "numericCode" => "887"
		    ],
		    [
		        "name" => "Zambia",
		        "alpha2Code" => "ZM",
		        "alpha3Code" => "ZMB",
		        "callingCodes" => "260",
		        "numericCode" => "894"
		    ],
		    [
		        "name" => "Zimbabwe",
		        "alpha2Code" => "ZW",
		        "alpha3Code" => "ZWE",
		        "callingCodes" => "263",
		        "numericCode" => "716"
		    ]
		];

		foreach ($countries as $country) {
			$c = new Country;
			$c->country_name = $country['name'];
			$c->country_code = $country['alpha2Code'];
			$c->phone_code = $country['callingCodes'];
			$c->save();
		}
    }
}

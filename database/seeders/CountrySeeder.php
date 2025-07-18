<?php

namespace Database\Seeders;

use App\Models\Country;
use DB;
use Illuminate\Database\Seeder;
use Schema;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            ['id' => '1', 'name' => 'Afghanistan', 'slug' => 'afghanistan', 'iso' => 'AF', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '2', 'name' => 'Albania', 'slug' => 'albania', 'iso' => 'AL', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '3', 'name' => 'Algeria', 'slug' => 'algeria', 'iso' => 'DZ', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '4', 'name' => 'American Samoa', 'slug' => 'american-samoa', 'iso' => 'AS', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '5', 'name' => 'Andorra', 'slug' => 'andorra', 'iso' => 'AD', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '6', 'name' => 'Angola', 'slug' => 'angola', 'iso' => 'AO', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '7', 'name' => 'Anguilla', 'slug' => 'anguilla', 'iso' => 'AI', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '8', 'name' => 'Antarctica', 'slug' => 'antarctica', 'iso' => 'AQ', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '9', 'name' => 'Antigua and Barbuda', 'slug' => 'antigua-and-barbuda', 'iso' => 'AG', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '10', 'name' => 'Argentina', 'slug' => 'argentina', 'iso' => 'AR', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '11', 'name' => 'Armenia', 'slug' => 'armenia', 'iso' => 'AM', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '12', 'name' => 'Aruba', 'slug' => 'aruba', 'iso' => 'AW', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '13', 'name' => 'Australia', 'slug' => 'australia', 'iso' => 'AU', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '14', 'name' => 'Austria', 'slug' => 'austria', 'iso' => 'AT', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '15', 'name' => 'Azerbaijan', 'slug' => 'azerbaijan', 'iso' => 'AZ', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '16', 'name' => 'Bahamas', 'slug' => 'bahamas', 'iso' => 'BS', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '17', 'name' => 'Bahrain', 'slug' => 'bahrain', 'iso' => 'BH', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '18', 'name' => 'Bangladesh', 'slug' => 'bangladesh', 'iso' => 'BD', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '19', 'name' => 'Barbados', 'slug' => 'barbados', 'iso' => 'BB', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '20', 'name' => 'Belarus', 'slug' => 'belarus', 'iso' => 'BY', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '21', 'name' => 'Belgium', 'slug' => 'belgium', 'iso' => 'BE', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '22', 'name' => 'Belize', 'slug' => 'belize', 'iso' => 'BZ', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '23', 'name' => 'Benin', 'slug' => 'benin', 'iso' => 'BJ', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '24', 'name' => 'Bermuda', 'slug' => 'bermuda', 'iso' => 'BM', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '25', 'name' => 'Bhutan', 'slug' => 'bhutan', 'iso' => 'BT', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '26', 'name' => 'Bosnia and Herzegovina', 'slug' => 'bosnia-and-herzegovina', 'iso' => 'BA', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '27', 'name' => 'Botswana', 'slug' => 'botswana', 'iso' => 'BW', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '28', 'name' => 'Bouvet Island', 'slug' => 'bouvet-island', 'iso' => 'BV', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '29', 'name' => 'Brazil', 'slug' => 'brazil', 'iso' => 'BR', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '30', 'name' => 'British Indian Ocean Territory', 'slug' => 'british-indian-ocean-territory', 'iso' => 'IO', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '31', 'name' => 'Brunei Darussalam', 'slug' => 'brunei-darussalam', 'iso' => 'BN', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '32', 'name' => 'Bulgaria', 'slug' => 'bulgaria', 'iso' => 'BG', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '33', 'name' => 'Burkina Faso', 'slug' => 'burkina-faso', 'iso' => 'BF', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '34', 'name' => 'Burundi', 'slug' => 'burundi', 'iso' => 'BI', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '35', 'name' => 'Cambodia', 'slug' => 'cambodia', 'iso' => 'KH', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '36', 'name' => 'Cameroon', 'slug' => 'cameroon', 'iso' => 'CM', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '37', 'name' => 'Canada', 'slug' => 'canada', 'iso' => 'CA', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '38', 'name' => 'Cape Verde', 'slug' => 'cape-verde', 'iso' => 'CV', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '39', 'name' => 'Cayman Islands', 'slug' => 'cayman-islands', 'iso' => 'KY', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '40', 'name' => 'Central African Republic', 'slug' => 'central-african-republic', 'iso' => 'CF', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '41', 'name' => 'Chad', 'slug' => 'chad', 'iso' => 'TD', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '42', 'name' => 'Chile', 'slug' => 'chile', 'iso' => 'CL', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '43', 'name' => 'China', 'slug' => 'china', 'iso' => 'CN', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '44', 'name' => 'Christmas Island', 'slug' => 'christmas-island', 'iso' => 'CX', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '45', 'name' => 'Cocos (Keeling) Islands', 'slug' => 'cocos-keeling-islands', 'iso' => 'CC', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '46', 'name' => 'Colombia', 'slug' => 'colombia', 'iso' => 'CO', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '47', 'name' => 'Comoros', 'slug' => 'comoros', 'iso' => 'KM', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '48', 'name' => 'Congo', 'slug' => 'congo', 'iso' => 'CG', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '49', 'name' => 'Cook Islands', 'slug' => 'cook-islands', 'iso' => 'CK', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '50', 'name' => 'Costa Rica', 'slug' => 'costa-rica', 'iso' => 'CR', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '51', 'name' => 'Croatia', 'slug' => 'croatia', 'iso' => 'HR', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '52', 'name' => 'Cuba', 'slug' => 'cuba', 'iso' => 'CU', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '53', 'name' => 'Cyprus', 'slug' => 'cyprus', 'iso' => 'CY', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '54', 'name' => 'Czech Republic', 'slug' => 'czech-republic', 'iso' => 'CZ', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '55', 'name' => 'Denmark', 'slug' => 'denmark', 'iso' => 'DK', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '56', 'name' => 'Djibouti', 'slug' => 'djibouti', 'iso' => 'DJ', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '57', 'name' => 'Dominica', 'slug' => 'dominica', 'iso' => 'DM', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '58', 'name' => 'Dominican Republic', 'slug' => 'dominican-republic', 'iso' => 'DO', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '59', 'name' => 'Ecuador', 'slug' => 'ecuador', 'iso' => 'EC', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '60', 'name' => 'Egypt', 'slug' => 'egypt', 'iso' => 'EG', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '61', 'name' => 'El Salvador', 'slug' => 'el-salvador', 'iso' => 'SV', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '62', 'name' => 'Equatorial Guinea', 'slug' => 'equatorial-guinea', 'iso' => 'GQ', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '63', 'name' => 'Eritrea', 'slug' => 'eritrea', 'iso' => 'ER', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '64', 'name' => 'Estonia', 'slug' => 'estonia', 'iso' => 'EE', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '65', 'name' => 'Ethiopia', 'slug' => 'ethiopia', 'iso' => 'ET', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '66', 'name' => 'Falkland Islands (Malvinas)', 'slug' => 'falkland-islands-malvinas', 'iso' => 'FK', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '67', 'name' => 'Faroe Islands', 'slug' => 'faroe-islands', 'iso' => 'FO', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '68', 'name' => 'Fiji', 'slug' => 'fiji', 'iso' => 'FJ', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '69', 'name' => 'Finland', 'slug' => 'finland', 'iso' => 'FI', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '70', 'name' => 'France', 'slug' => 'france', 'iso' => 'FR', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '71', 'name' => 'French Guiana', 'slug' => 'french-guiana', 'iso' => 'GF', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '72', 'name' => 'French Polynesia', 'slug' => 'french-polynesia', 'iso' => 'PF', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '73', 'name' => 'French Southern Territories', 'slug' => 'french-southern-territories', 'iso' => 'TF', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '74', 'name' => 'Gabon', 'slug' => 'gabon', 'iso' => 'GA', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '75', 'name' => 'Gambia', 'slug' => 'gambia', 'iso' => 'GM', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '76', 'name' => 'Georgia', 'slug' => 'georgia', 'iso' => 'GE', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '77', 'name' => 'Germany', 'slug' => 'germany', 'iso' => 'DE', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '78', 'name' => 'Ghana', 'slug' => 'ghana', 'iso' => 'GH', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '79', 'name' => 'Gibraltar', 'slug' => 'gibraltar', 'iso' => 'GI', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '80', 'name' => 'Greece', 'slug' => 'greece', 'iso' => 'GR', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '81', 'name' => 'Greenland', 'slug' => 'greenland', 'iso' => 'GL', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '82', 'name' => 'Grenada', 'slug' => 'grenada', 'iso' => 'GD', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '83', 'name' => 'Guadeloupe', 'slug' => 'guadeloupe', 'iso' => 'GP', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '84', 'name' => 'Guam', 'slug' => 'guam', 'iso' => 'GU', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '85', 'name' => 'Guatemala', 'slug' => 'guatemala', 'iso' => 'GT', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '86', 'name' => 'Guernsey', 'slug' => 'guernsey', 'iso' => 'GG', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '87', 'name' => 'Guinea', 'slug' => 'guinea', 'iso' => 'GN', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '88', 'name' => 'Guinea-Bissau', 'slug' => 'guinea-bissau', 'iso' => 'GW', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '89', 'name' => 'Guyana', 'slug' => 'guyana', 'iso' => 'GY', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '90', 'name' => 'Haiti', 'slug' => 'haiti', 'iso' => 'HT', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '91', 'name' => 'Heard Island and McDonald Islands', 'slug' => 'heard-island-and-mcdonald-islands', 'iso' => 'HM', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '92', 'name' => 'Holy See (Vatican City State)', 'slug' => 'holy-see-vatican-city-state', 'iso' => 'VA', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '93', 'name' => 'Honduras', 'slug' => 'honduras', 'iso' => 'HN', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '94', 'name' => 'Hong Kong', 'slug' => 'hong-kong', 'iso' => 'HK', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '95', 'name' => 'Hungary', 'slug' => 'hungary', 'iso' => 'HU', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '96', 'name' => 'Iceland', 'slug' => 'iceland', 'iso' => 'IS', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '97', 'name' => 'India', 'slug' => 'india', 'iso' => 'IN', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '98', 'name' => 'Indonesia', 'slug' => 'indonesia', 'iso' => 'ID', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '99', 'name' => 'Iraq', 'slug' => 'iraq', 'iso' => 'IQ', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '100', 'name' => 'Ireland', 'slug' => 'ireland', 'iso' => 'IE', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '101', 'name' => 'Isle of Man', 'slug' => 'isle-of-man', 'iso' => 'IM', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '102', 'name' => 'Israel', 'slug' => 'israel', 'iso' => 'IL', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '103', 'name' => 'Italy', 'slug' => 'italy', 'iso' => 'IT', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '104', 'name' => 'Jamaica', 'slug' => 'jamaica', 'iso' => 'JM', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '105', 'name' => 'Japan', 'slug' => 'japan', 'iso' => 'JP', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '106', 'name' => 'Jersey', 'slug' => 'jersey', 'iso' => 'JE', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '107', 'name' => 'Jordan', 'slug' => 'jordan', 'iso' => 'JO', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '108', 'name' => 'Kazakhstan', 'slug' => 'kazakhstan', 'iso' => 'KZ', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '109', 'name' => 'Kenya', 'slug' => 'kenya', 'iso' => 'KE', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '110', 'name' => 'Kiribati', 'slug' => 'kiribati', 'iso' => 'KI', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '111', 'name' => 'Kuwait', 'slug' => 'kuwait', 'iso' => 'KW', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '112', 'name' => 'Kyrgyzstan', 'slug' => 'kyrgyzstan', 'iso' => 'KG', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '113', 'name' => 'Lao Peoples Democratic Republic', 'slug' => 'lao-peoples-democratic-republic', 'iso' => 'LA', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '114', 'name' => 'Latvia', 'slug' => 'latvia', 'iso' => 'LV', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '115', 'name' => 'Lebanon', 'slug' => 'lebanon', 'iso' => 'LB', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '116', 'name' => 'Lesotho', 'slug' => 'lesotho', 'iso' => 'LS', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '117', 'name' => 'Liberia', 'slug' => 'liberia', 'iso' => 'LR', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '118', 'name' => 'Libya', 'slug' => 'libya', 'iso' => 'LY', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '119', 'name' => 'Liechtenstein', 'slug' => 'liechtenstein', 'iso' => 'LI', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '120', 'name' => 'Lithuania', 'slug' => 'lithuania', 'iso' => 'LT', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '121', 'name' => 'Luxembourg', 'slug' => 'luxembourg', 'iso' => 'LU', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '122', 'name' => 'Macao', 'slug' => 'macao', 'iso' => 'MO', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '123', 'name' => 'Madagascar', 'slug' => 'madagascar', 'iso' => 'MG', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '124', 'name' => 'Malawi', 'slug' => 'malawi', 'iso' => 'MW', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '125', 'name' => 'Malaysia', 'slug' => 'malaysia', 'iso' => 'MY', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '126', 'name' => 'Maldives', 'slug' => 'maldives', 'iso' => 'MV', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '127', 'name' => 'Mali', 'slug' => 'mali', 'iso' => 'ML', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '128', 'name' => 'Malta', 'slug' => 'malta', 'iso' => 'MT', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '129', 'name' => 'Marshall Islands', 'slug' => 'marshall-islands', 'iso' => 'MH', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '130', 'name' => 'Martinique', 'slug' => 'martinique', 'iso' => 'MQ', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '131', 'name' => 'Mauritania', 'slug' => 'mauritania', 'iso' => 'MR', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '132', 'name' => 'Mauritius', 'slug' => 'mauritius', 'iso' => 'MU', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '133', 'name' => 'Mayotte', 'slug' => 'mayotte', 'iso' => 'YT', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '134', 'name' => 'Mexico', 'slug' => 'mexico', 'iso' => 'MX', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '135', 'name' => 'Monaco', 'slug' => 'monaco', 'iso' => 'MC', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '136', 'name' => 'Mongolia', 'slug' => 'mongolia', 'iso' => 'MN', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '137', 'name' => 'Montenegro', 'slug' => 'montenegro', 'iso' => 'ME', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '138', 'name' => 'Montserrat', 'slug' => 'montserrat', 'iso' => 'MS', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '139', 'name' => 'Morocco', 'slug' => 'morocco', 'iso' => 'MA', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '140', 'name' => 'Mozambique', 'slug' => 'mozambique', 'iso' => 'MZ', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '141', 'name' => 'Myanmar', 'slug' => 'myanmar', 'iso' => 'MM', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '142', 'name' => 'Namibia', 'slug' => 'namibia', 'iso' => 'NA', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '143', 'name' => 'Nauru', 'slug' => 'nauru', 'iso' => 'NR', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '144', 'name' => 'Nepal', 'slug' => 'nepal', 'iso' => 'NP', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '145', 'name' => 'Netherlands', 'slug' => 'netherlands', 'iso' => 'NL', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '146', 'name' => 'New Caledonia', 'slug' => 'new-caledonia', 'iso' => 'NC', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '147', 'name' => 'New Zealand', 'slug' => 'new-zealand', 'iso' => 'NZ', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '148', 'name' => 'Nicaragua', 'slug' => 'nicaragua', 'iso' => 'NI', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '149', 'name' => 'Niger', 'slug' => 'niger', 'iso' => 'NE', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '150', 'name' => 'Nigeria', 'slug' => 'nigeria', 'iso' => 'NG', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '151', 'name' => 'Niue', 'slug' => 'niue', 'iso' => 'NU', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '152', 'name' => 'Norfolk Island', 'slug' => 'norfolk-island', 'iso' => 'NF', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '153', 'name' => 'Northern Mariana Islands', 'slug' => 'northern-mariana-islands', 'iso' => 'MP', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '154', 'name' => 'Norway', 'slug' => 'norway', 'iso' => 'NO', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '155', 'name' => 'Oman', 'slug' => 'oman', 'iso' => 'OM', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '156', 'name' => 'Pakistan', 'slug' => 'pakistan', 'iso' => 'PK', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '157', 'name' => 'Palau', 'slug' => 'palau', 'iso' => 'PW', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '158', 'name' => 'Panama', 'slug' => 'panama', 'iso' => 'PA', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '159', 'name' => 'Papua New Guinea', 'slug' => 'papua-new-guinea', 'iso' => 'PG', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '160', 'name' => 'Paraguay', 'slug' => 'paraguay', 'iso' => 'PY', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '161', 'name' => 'Peru', 'slug' => 'peru', 'iso' => 'PE', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '162', 'name' => 'Philippines', 'slug' => 'philippines', 'iso' => 'PH', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '163', 'name' => 'Pitcairn', 'slug' => 'pitcairn', 'iso' => 'PN', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '164', 'name' => 'Poland', 'slug' => 'poland', 'iso' => 'PL', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '165', 'name' => 'Portugal', 'slug' => 'portugal', 'iso' => 'PT', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '166', 'name' => 'Puerto Rico', 'slug' => 'puerto-rico', 'iso' => 'PR', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '167', 'name' => 'Qatar', 'slug' => 'qatar', 'iso' => 'QA', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '168', 'name' => 'Romania', 'slug' => 'romania', 'iso' => 'RO', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '169', 'name' => 'Russian Federation', 'slug' => 'russian-federation', 'iso' => 'RU', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '170', 'name' => 'Rwanda', 'slug' => 'rwanda', 'iso' => 'RW', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '171', 'name' => 'Saint Kitts and Nevis', 'slug' => 'saint-kitts-and-nevis', 'iso' => 'KN', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '172', 'name' => 'Saint Lucia', 'slug' => 'saint-lucia', 'iso' => 'LC', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '173', 'name' => 'Saint Martin (French part)', 'slug' => 'saint-martin-french-part', 'iso' => 'MF', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '174', 'name' => 'Saint Pierre and Miquelon', 'slug' => 'saint-pierre-and-miquelon', 'iso' => 'PM', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '175', 'name' => 'Saint Vincent and the Grenadines', 'slug' => 'saint-vincent-and-the-grenadines', 'iso' => 'VC', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '176', 'name' => 'Samoa', 'slug' => 'samoa', 'iso' => 'WS', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '177', 'name' => 'San Marino', 'slug' => 'san-marino', 'iso' => 'SM', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '178', 'name' => 'Sao Tome and Principe', 'slug' => 'sao-tome-and-principe', 'iso' => 'ST', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '179', 'name' => 'Saudi Arabia', 'slug' => 'saudi-arabia', 'iso' => 'SA', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '180', 'name' => 'Senegal', 'slug' => 'senegal', 'iso' => 'SN', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '181', 'name' => 'Serbia', 'slug' => 'serbia', 'iso' => 'RS', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '182', 'name' => 'Seychelles', 'slug' => 'seychelles', 'iso' => 'SC', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '183', 'name' => 'Sierra Leone', 'slug' => 'sierra-leone', 'iso' => 'SL', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '184', 'name' => 'Singapore', 'slug' => 'singapore', 'iso' => 'SG', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '185', 'name' => 'Sint Maarten (Dutch part)', 'slug' => 'sint-maarten-dutch-part', 'iso' => 'SX', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '186', 'name' => 'Slovakia', 'slug' => 'slovakia', 'iso' => 'SK', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '187', 'name' => 'Slovenia', 'slug' => 'slovenia', 'iso' => 'SI', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '188', 'name' => 'Solomon Islands', 'slug' => 'solomon-islands', 'iso' => 'SB', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '189', 'name' => 'Somalia', 'slug' => 'somalia', 'iso' => 'SO', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '190', 'name' => 'South Africa', 'slug' => 'south-africa', 'iso' => 'ZA', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '191', 'name' => 'South Georgia and the South Sandwich Islands', 'slug' => 'south-georgia-and-the-south-sandwich-islands', 'iso' => 'GS', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '192', 'name' => 'South Sudan', 'slug' => 'south-sudan', 'iso' => 'SS', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '193', 'name' => 'Spain', 'slug' => 'spain', 'iso' => 'ES', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '194', 'name' => 'Sri Lanka', 'slug' => 'sri-lanka', 'iso' => 'LK', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '195', 'name' => 'Sudan', 'slug' => 'sudan', 'iso' => 'SD', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '196', 'name' => 'Suriname', 'slug' => 'suriname', 'iso' => 'SR', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '197', 'name' => 'Svalbard and Jan Mayen', 'slug' => 'svalbard-and-jan-mayen', 'iso' => 'SJ', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '198', 'name' => 'Swaziland', 'slug' => 'swaziland', 'iso' => 'SZ', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '199', 'name' => 'Sweden', 'slug' => 'sweden', 'iso' => 'SE', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '200', 'name' => 'Switzerland', 'slug' => 'switzerland', 'iso' => 'CH', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '201', 'name' => 'Syrian Arab Republic', 'slug' => 'syrian-arab-republic', 'iso' => 'SY', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '202', 'name' => 'Tajikistan', 'slug' => 'tajikistan', 'iso' => 'TJ', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '203', 'name' => 'Thailand', 'slug' => 'thailand', 'iso' => 'TH', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '204', 'name' => 'Timor-Leste', 'slug' => 'timor-leste', 'iso' => 'TL', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '205', 'name' => 'Togo', 'slug' => 'togo', 'iso' => 'TG', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '206', 'name' => 'Tokelau', 'slug' => 'tokelau', 'iso' => 'TK', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '207', 'name' => 'Tonga', 'slug' => 'tonga', 'iso' => 'TO', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '208', 'name' => 'Trinidad and Tobago', 'slug' => 'trinidad-and-tobago', 'iso' => 'TT', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '209', 'name' => 'Tunisia', 'slug' => 'tunisia', 'iso' => 'TN', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '210', 'name' => 'Turkey', 'slug' => 'turkey', 'iso' => 'TR', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '211', 'name' => 'Turkmenistan', 'slug' => 'turkmenistan', 'iso' => 'TM', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '212', 'name' => 'Turks and Caicos Islands', 'slug' => 'turks-and-caicos-islands', 'iso' => 'TC', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '213', 'name' => 'Tuvalu', 'slug' => 'tuvalu', 'iso' => 'TV', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '214', 'name' => 'Uganda', 'slug' => 'uganda', 'iso' => 'UG', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '215', 'name' => 'Ukraine', 'slug' => 'ukraine', 'iso' => 'UA', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '216', 'name' => 'United Arab Emirates', 'slug' => 'united-arab-emirates', 'iso' => 'AE', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '217', 'name' => 'United Kingdom', 'slug' => 'united-kingdom', 'iso' => 'GB', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '218', 'name' => 'United States', 'slug' => 'united-states', 'iso' => 'US', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '219', 'name' => 'United States Minor Outlying Islands', 'slug' => 'united-states-minor-outlying-islands', 'iso' => 'UM', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '220', 'name' => 'Uruguay', 'slug' => 'uruguay', 'iso' => 'UY', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '221', 'name' => 'Uzbekistan', 'slug' => 'uzbekistan', 'iso' => 'UZ', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '222', 'name' => 'Vanuatu', 'slug' => 'vanuatu', 'iso' => 'VU', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '223', 'name' => 'Viet Nam', 'slug' => 'viet-nam', 'iso' => 'VN', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '224', 'name' => 'Wallis and Futuna', 'slug' => 'wallis-and-futuna', 'iso' => 'WF', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '225', 'name' => 'Western Sahara', 'slug' => 'western-sahara', 'iso' => 'EH', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '226', 'name' => 'Yemen', 'slug' => 'yemen', 'iso' => 'YE', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '227', 'name' => 'Zambia', 'slug' => 'zambia', 'iso' => 'ZM', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => '228', 'name' => 'Zimbabwe', 'slug' => 'zimbabwe', 'iso' => 'ZW', 'image_name' => NULL, 'created_at' => now(), 'updated_at' => now()]
        ];

        Schema::disableForeignKeyConstraints();
        if (\App::isLocal()) {
            DB::table('countries')->truncate();
        }
        Country::insert($countries);
        Schema::enableForeignKeyConstraints();
    }
}

<?php

namespace Database\Seeders;

use App\Models\{
    Uom,
    Item,
    User,
    State,
    Store,
    Branch,
    Account,
    Company,
    TaxType,
    ItemGroup,
    BillSundry,
    InvoiceType,
    TaxCategory,
    AccountGroup,
    VoucherSeries,
    AccountingType,
    FinancialYear,
    SerialNumber,
};
use Illuminate\Support\Str;
use App\Models\InvoicePrintConfig;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $states = [
            ['code' => '01', 'name' => 'JAMMU AND KASHMIR'],
            ['code' => '02', 'name' => 'HIMACHAL PRADESH'],
            ['code' => '03', 'name' => 'PUNJAB'],
            ['code' => '04', 'name' => 'CHANDIGARH'],
            ['code' => '05', 'name' => 'UTTARAKHAND'],
            ['code' => '06', 'name' => 'HARYANA'],
            ['code' => '07', 'name' => 'DELHI'],
            ['code' => '08', 'name' => 'RAJASTHAN'],
            ['code' => '09', 'name' => 'UTTAR PRADESH'],
            ['code' => '10', 'name' => 'BIHAR'],
            ['code' => '11', 'name' => 'SIKKIM'],
            ['code' => '12', 'name' => 'ARUNACHAL PRADESH'],
            ['code' => '13', 'name' => 'NAGALAND'],
            ['code' => '14', 'name' => 'MANIPUR'],
            ['code' => '15', 'name' => 'MIZORAM'],
            ['code' => '16', 'name' => 'TRIPURA'],
            ['code' => '17', 'name' => 'MEGHALAYA'],
            ['code' => '18', 'name' => 'ASSAM'],
            ['code' => '19', 'name' => 'WEST BENGAL'],
            ['code' => '20', 'name' => 'JHARKHAND'],
            ['code' => '21', 'name' => 'ODISHA'],
            ['code' => '22', 'name' => 'CHATTISGARH'],
            ['code' => '23', 'name' => 'MADHYA PRADESH'],
            ['code' => '24', 'name' => 'GUJARAT'],
            ['code' => '25', 'name' => 'Daman & Diu'],
            ['code' => '26', 'name' => 'DADRA AND NAGAR HAVELI AND DAMAN AND DIU (NEWLY MERGED UT)'],
            ['code' => '27', 'name' => 'MAHARASHTRA'],
            ['code' => '28', 'name' => 'ANDHRA PRADESH (BEFORE DIVISION)'],
            ['code' => '29', 'name' => 'KARNATAKA'],
            ['code' => '30', 'name' => 'GOA'],
            ['code' => '31', 'name' => 'LAKSHADWEEP'],
            ['code' => '32', 'name' => 'KERELA'],
            ['code' => '33', 'name' => 'TAMIL NADU'],
            ['code' => '34', 'name' => 'PUDUCHERRY'],
            ['code' => '35', 'name' => 'ANDAMAN AND NICOBAR ISLANDS'],
            ['code' => '36', 'name' => 'TELANGANA'],
            ['code' => '37', 'name' => 'ANDHRA PRADESH (NEWLY ADDED)'],
            ['code' => '38', 'name' => 'LADAKH (NEWLY ADDED)'],
            ['code' => '97', 'name' => 'OTHER TERRITORY'],
            ['code' => '99', 'name' => 'CENTRE JURISDICTION'],
        ];
        foreach ($states as $state) {
            State::create([
                'code' => $state['code'],
                'name' => $state['name'],
            ]);
        }
        Company::create([
            'id' => 1,
            'name' => 'Wire Company',
            'address' => fake()->address,
            'city' => fake()->city,
            'state_id' => 29,
            'country' => 'India',
            'pincode' => '560001',
            'phone' => fake()->phoneNumber,
            'email' => fake()->email,
            'website' => fake()->url(),
            'gstin' => '29HHGFG9999G1JZ',
        ]);

        $dateRange = getUserFinancialYearDates();
        FinancialYear::create([
            'id' => 1,
            'company_id' => Company::first()->id,
            'name' => 'FY ' . date('Y') . '-' . (date('y') + 1),
            'start_date' => $dateRange['from_date'],
            'end_date' => $dateRange['to_date'],
            'is_active' => true,
        ]);
        FinancialYear::create([
            'id' => 2,
            'company_id' => Company::first()->id,
            'name' => 'FY ' . date('Y') + 1 . '-' . (date('y') + 2),
            'start_date' => date('Y') + 1 . '-04-01',
            'end_date' => date('Y') + 2 . '-03-31',
            'is_active' => true,
        ]);

        $currentBranch = Branch::create([
            'id' => 1,
            'name' => 'Main',
            'company_id' => '1',
            'address' => '123 Main St',
            'city' => 'Anytown',
            'state' => 'Anystate',
            'country' => 'Anycountry',
            'pincode' => '123456',
            'phone' => '1234567890',
            'email' => 'dummy@email.com',
            'website' => 'www.example.com',
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin@admin.com'),
            'is_super_admin' => true,
            'company_id' => 1,
            'branch_id' => 1,
            'financial_year_id' => FinancialYear::first()->id,
        ]);

        $branches = Branch::all();
        foreach ($branches as $branch) {
            Store::create([
                'branch_id' => $branch['id'],
                'name' => $branch['name'] . ' MC',
                'slug' => Str::slug($branch['name'] . ' MC')
            ]);
        }
        Store::create([
            'branch_id' => Branch::first()->id,
            'name' => 'Godown MC',
            'slug' => Str::slug('Godown MC')
        ]);

        $invoiceTypes = [
            ['id' => 1, 'print_title' => 'Purchase Invoice', 'name' => 'Purchase', 'transaction_category' => 'purchase', 'sn_input_type' => 'input', 'in_out' => 'inward', 'menu_order' => 2, 'bg_color' => '#fefed1', 'stock_value' => '+', 'account_value' => 'cr'],
            ['id' => 2, 'print_title' => 'Purchase Return Voucher', 'allowed_return_from' => 1, 'name' => 'Purchase Return', 'transaction_category' => 'return', 'sn_input_type' => 'select', 'in_out' => 'outward', 'menu_order' => 4, 'bg_color' => '#ffebe1', 'stock_value' => '-', 'account_value' => 'dr'],
            ['id' => 3, 'print_title' => 'Sales Invoice', 'name' => 'Sale', 'transaction_category' => 'sale', 'sn_input_type' => 'select', 'in_out' => 'outward', 'menu_order' => 1, 'bg_color' => '#d2f0f0', 'stock_value' => '-', 'account_value' => 'dr'],
            ['id' => 4, 'print_title' => 'Sale Return Voucher', 'allowed_return_from' => 3, 'name' => 'Sale Return', 'transaction_category' => 'return', 'sn_input_type' => 'select', 'in_out' => 'inward', 'menu_order' => 3, 'bg_color' => '#ffebe1', 'stock_value' => '+', 'account_value' => 'cr'],
            ['id' => 5, 'print_title' => 'Stock Transfer Voucher', 'name' => 'Stock Transfer', 'transaction_category' => 'transfer', 'sn_input_type' => 'select', 'in_out' => 'transfer', 'menu_order' => 7, 'bg_color' => '#d2f0f0', 'stock_value' => null],
            ['id' => 6, 'print_title' => 'Material Issued Voucher', 'name' => 'Material Issued', 'transaction_category' => 'material', 'sn_input_type' => 'select', 'in_out' => 'outward', 'menu_order' => 5, 'bg_color' => '#d2f0f0', 'stock_value' => '-', 'account_value' => 'dr'],
            ['id' => 7, 'print_title' => 'Material Received Voucher', 'allowed_return_from' => 6, 'name' => 'Material Received', 'transaction_category' => 'material', 'sn_input_type' => 'select', 'in_out' => 'inward', 'menu_order' => 6, 'bg_color' => '#ffffd2', 'stock_value' => '+', 'account_value' => 'cr'],
            ['id' => 8, 'print_title' => 'Sale Quotation', 'name' => 'Sale Quotation', 'transaction_category' => 'other', 'sn_input_type' => 'none', 'in_out' => 'none', 'menu_order' => 8, 'bg_color' => '#ffffd2', 'stock_value' => null],
            ['id' => 9, 'print_title' => 'Purchase Indent', 'name' => 'Purchase Quotation', 'transaction_category' => 'other', 'sn_input_type' => 'none', 'in_out' => 'none', 'menu_order' => 9, 'bg_color' => '#ffffd2', 'stock_value' => null],
            ['id' => 10, 'print_title' => 'Production Voucher', 'name' => 'Production', 'transaction_category' => 'purchase', 'sn_input_type' => 'input', 'in_out' => 'inward', 'menu_order' => 10, 'bg_color' => '#ffffd2', 'stock_value' => '+', 'account_value' => 'cr'],
        ];
        foreach ($invoiceTypes as $invoiceType) {
            InvoiceType::create(
                [
                    'name' => $invoiceType['name'],
                    'slug' => Str::slug($invoiceType['name']),
                    'print_title' => $invoiceType['print_title'],
                    'transaction_category' => $invoiceType['transaction_category'],
                    'sn_input_type' => $invoiceType['sn_input_type'],
                    'in_out' => $invoiceType['in_out'],
                    'bg_color' => $invoiceType['bg_color'],
                    'allowed_return_from' => $invoiceType['allowed_return_from'] ?? null,
                    'menu_order' => $invoiceType['menu_order'],
                    'stock_value' => $invoiceType['stock_value'],
                    'account_value' => $invoiceType['account_value'] ?? null,
                ]
            );
        }

        $invoiceTypes = InvoiceType::all();
        foreach ($invoiceTypes as $invoiceType) {

            $type = $invoiceType->transaction_category == 'purchase' ? 'manual' : 'automatic';

            VoucherSeries::create([
                'name' => 'Main',
                'branch_id' => Branch::first()->id,
                'invoice_type_id' => $invoiceType['id'],
                'vn_type' => $type
            ]);
        }

        $accountingTypes = [
            ['id' => 1, 'name' => 'Receipt', 'bg_color' => '#fefed1', 'order' => 1],
            ['id' => 2, 'name' => 'Contra', 'bg_color' => '#ffebe1', 'order' => 2],
            ['id' => 3, 'name' => 'Payment', 'bg_color' => '#d2f0f0', 'order' => 3],
            ['id' => 4, 'name' => 'Journal', 'bg_color' => '#ffebe1', 'order' => 4]
        ];
        foreach ($accountingTypes as $accountingType) {
            AccountingType::create(
                [
                    'name' => $accountingType['name'],
                    'slug' => Str::slug($accountingType['name']),
                    'bg_color' => $accountingType['bg_color'],
                    'order' => $accountingType['order']
                ]
            );
        }

        $billSundries = [
            ['name' => 'Add. Tax/ Surcharge on VAT', 'adjustment' => '+'],
            ['name' => 'Central Sales Tax', 'adjustment' => '+'],
            ['name' => 'Cess on GST', 'adjustment' => '+'],
            ['name' => 'Cess on GST (ITC-None)', 'adjustment' => '+'],
            ['name' => 'CGST', 'adjustment' => '+'],
            ['name' => 'CGST (ITC-None)', 'adjustment' => '+'],
            ['name' => 'Development Tax', 'adjustment' => '+'],
            ['name' => 'Discount', 'adjustment' => '-'],
            ['name' => 'Edu. Cess on Excise', 'adjustment' => '+'],
            ['name' => 'Edu. Cess on Service Tax', 'adjustment' => '+'],
            ['name' => 'Excise Duty', 'adjustment' => '+'],
            ['name' => 'Freight & Forwarding Charges', 'adjustment' => '+'],
            ['name' => 'IGST', 'adjustment' => '+'],
            ['name' => 'IGST (ITC-None)', 'adjustment' => '+'],
            ['name' => 'Rounded Off (-)', 'adjustment' => '-'],
            ['name' => 'Rounded Off (+)', 'adjustment' => '+'],
            ['name' => 'Service Charges', 'adjustment' => '+'],
            ['name' => 'Service Tax', 'adjustment' => '+'],
            ['name' => 'Service-Installation Charge (Itm.1 & 2)', 'adjustment' => '+'],
            ['name' => 'SGST', 'adjustment' => '+'],
            ['name' => 'SGST (ITC-None)', 'adjustment' => '+'],
            ['name' => 'SHE Cess on Excise', 'adjustment' => '+'],
            ['name' => 'SHE Cess on Service Tax', 'adjustment' => '+'],
            ['name' => 'VAT', 'adjustment' => '+'],
        ];
        foreach ($billSundries as $billSundry) {
            BillSundry::create([
                'name'              => $billSundry['name'],
                'adjustment'        => $billSundry['adjustment']
            ]);
        }
        $taxcategories = [
            ['id' => 1, 'name' => 'Exempt', 'igst_pct' => '0.00', 'cgst_pct' => '0.00', 'sgst_pct' => '0.00', 'cess_pct' => '0.00'],
            ['id' => 2, 'name' => 'GST 0%', 'igst_pct' => '0.00', 'cgst_pct' => '0.00', 'sgst_pct' => '0.00', 'cess_pct' => '0.00'],
            ['id' => 3, 'name' => 'GST 5%', 'igst_pct' => '5.00', 'cgst_pct' => '2.50', 'sgst_pct' => '2.50', 'cess_pct' => '0.00'],
            ['id' => 4, 'name' => 'GST 12%', 'igst_pct' => '12.00', 'cgst_pct' => '6.00', 'sgst_pct' => '6.00', 'cess_pct' => '0.00'],
            ['id' => 5, 'name' => 'GST 18%', 'igst_pct' => '18.00', 'cgst_pct' => '9.00', 'sgst_pct' => '9.00', 'cess_pct' => '0.00'],
            ['id' => 6, 'name' => 'GST 28%', 'igst_pct' => '28.00', 'cgst_pct' => '14.00', 'sgst_pct' => '14.00', 'cess_pct' => '0.00'],
            ['id' => 7, 'name' => 'GST 28+12%', 'igst_pct' => '28.00', 'cgst_pct' => '14.00', 'sgst_pct' => '14.00', 'cess_pct' => '12.00'],
        ];
        foreach ($taxcategories as $taxcategory) {
            TaxCategory::create([
                'id' => $taxcategory['id'],
                'name' => $taxcategory['name'],
                'igst_pct' => $taxcategory['igst_pct'],
                'cgst_pct' => $taxcategory['cgst_pct'],
                'sgst_pct' => $taxcategory['sgst_pct'],
                'cess_pct' => $taxcategory['cess_pct'],
            ]);
        }
        $units = [
            ['id' => 1, 'name' => 'Pcs.', 'uqc' => 'PCS-PIECES', 'deletable' => false],
            ['id' => 2, 'name' => 'Gms.', 'uqc' => 'GMS-GRAMMES', 'deletable' => false],
            ['id' => 3, 'name' => 'Units', 'uqc' => 'UNT-UNITS', 'deletable' => false],
            ['id' => 4, 'name' => 'Kgs.', 'uqc' => 'KGS-KILOGRAMS', 'deletable' => false],
            ['id' => 5, 'name' => 'Metre', 'uqc' => 'MTR-METERS', 'deletable' => false],
            ['id' => 6, 'name' => 'N.A.', 'uqc' => 'NA', 'deletable' => false],
        ];
        foreach ($units as $unit) {
            Uom::create([
                'id' => $unit['id'],
                'name' => $unit['name'],
                'uqc' => $unit['uqc'],
                'deletable' => $unit['deletable'],
            ]);
        }
        $taxTypes = [
            ['id' => 1, 'name' => 'Local', 'for' => 'local'],
            ['id' => 2, 'name' => 'Central', 'for' => 'central'],
        ];
        foreach ($taxTypes as $taxType) {
            TaxType::create(
                [
                    'name' => $taxType['name'],
                    'for' => $taxType['for']
                ]
            );
        }

        $f = false;
        $accountgroups = [
            //Primary Accounts
            ['id' => 1, 'name' => 'Current Assets', 'primary_id' => null, 'is_editable' => $f, 'is_deletable' => $f],
            ['id' => 2, 'name' => 'Capital Account', 'primary_id' => null, 'is_editable' => $f, 'is_deletable' => $f],
            ['id' => 3, 'name' => 'Current Liabilities', 'primary_id' => null, 'is_editable' => $f, 'is_deletable' => $f],
            ['id' => 4, 'name' => 'Fixed Assets', 'primary_id' => null, 'is_editable' => $f, 'is_deletable' => $f],
            ['id' => 5, 'name' => 'Loans (Liability)', 'primary_id' => null, 'is_editable' => $f, 'is_deletable' => $f],
            ['id' => 6, 'name' => 'Revenue Accounts', 'primary_id' => null, 'is_editable' => $f, 'is_deletable' => $f],
            ['id' => 7, 'name' => 'Investments', 'primary_id' => null, 'is_editable' => $f, 'is_deletable' => $f],
            ['id' => 8, 'name' => 'Pre-Perative Expenses', 'primary_id' => null, 'is_editable' => $f, 'is_deletable' => $f],
            ['id' => 9, 'name' => 'Profit & Loss', 'primary_id' => null, 'is_editable' => $f, 'is_deletable' => $f],
            ['id' => 10, 'name' => 'Suspense Account', 'primary_id' => null, 'is_editable' => $f, 'is_deletable' => $f],
            //Current Assets
            ['id' => 11, 'name' => 'Bank Accounts', 'primary_id' => 1, 'is_editable' => $f, 'is_deletable' => $f],
            ['id' => 12, 'name' => 'Cash-in-Hand', 'primary_id' => 1, 'is_editable' => $f, 'is_deletable' => $f],
            ['id' => 13, 'name' => 'Loans & Advances (Asset)', 'primary_id' => 1, 'is_editable' => $f, 'is_deletable' => $f],
            ['id' => 14, 'name' => 'Securities & Deposits (Asset)', 'primary_id' => 1, 'is_editable' => $f, 'is_deletable' => $f],
            ['id' => 15, 'name' => 'Stock-in-hand', 'primary_id' => 1, 'is_editable' => $f, 'is_deletable' => $f],
            ['id' => 16, 'name' => 'Sundry Debtors', 'primary_id' => 1, 'is_editable' => $f, 'is_deletable' => $f],
            //Capital Accounts
            ['id' => 17, 'name' => 'Reseves & Surplus', 'primary_id' => 2, 'is_editable' => $f, 'is_deletable' => $f],
            //Current Liabilities
            ['id' => 18, 'name' => 'Duties & Taxes', 'primary_id' => 3, 'is_editable' => $f, 'is_deletable' => $f],
            ['id' => 19, 'name' => 'Provisions/Expenses Payable', 'primary_id' => 3, 'is_editable' => $f, 'is_deletable' => $f],
            ['id' => 20, 'name' => 'Sundry Creditors', 'primary_id' => 3, 'is_editable' => $f, 'is_deletable' => $f],
            //Loans (Liability)
            ['id' => 21, 'name' => 'Bank O/D Account', 'primary_id' => 5, 'is_editable' => $f, 'is_deletable' => $f],
            ['id' => 22, 'name' => 'Secured Loans', 'primary_id' => 5, 'is_editable' => $f, 'is_deletable' => $f],
            ['id' => 23, 'name' => 'Unsecured Loans', 'primary_id' => 5, 'is_editable' => $f, 'is_deletable' => $f],
            //Revenue Accounts
            ['id' => 24, 'name' => 'Expenses (Direct/Mfg)', 'primary_id' => 6, 'is_editable' => $f, 'is_deletable' => $f],
            ['id' => 25, 'name' => 'Expenses (Indirect/Admin)', 'primary_id' => 6, 'is_editable' => $f, 'is_deletable' => $f],
            ['id' => 26, 'name' => 'Income (Direct/Opr)', 'primary_id' => 6, 'is_editable' => $f, 'is_deletable' => $f],
            ['id' => 27, 'name' => 'Income (Indirect)', 'primary_id' => 6, 'is_editable' => $f, 'is_deletable' => $f],
            ['id' => 28, 'name' => 'Purchase', 'primary_id' => 6, 'is_editable' => $f, 'is_deletable' => $f],
            ['id' => 29, 'name' => 'Sale', 'primary_id' => 6, 'is_editable' => $f, 'is_deletable' => $f],
            //Revenue Accounts
            ['id' => 30, 'name' => 'Loan Interests', 'primary_id' => 25, 'is_editable' => $f, 'is_deletable' => $f],
        ];
        foreach ($accountgroups as $accountgroup) {
            AccountGroup::create([
                'id'           => $accountgroup['id'],
                'name'         => $accountgroup['name'],
                'primary_id'   => $accountgroup['primary_id'],
                'is_editable'  => $accountgroup['is_editable'],
                'is_deletable' => $accountgroup['is_deletable'],
            ]);
        }
        AccountGroup::create([
            'name' => "{$currentBranch->name} Branch Customers",
            'primary_id' => 16,
            'is_editable' => true,
            'is_deletable' => true,
        ]);
        $accounts = [
            ['id' => 1, 'group_id' => 12, 'name' => 'Cash'],
            ['id' => 2, 'group_id' => 1, 'name' => 'SGST Adjustable Agnst. Advance'],
            ['id' => 3, 'group_id' => 1, 'name' => 'SGST Input Available (RCM)'],
            ['id' => 4, 'group_id' => 1, 'name' => 'CGST Adjustable Agnst. Advance'],
            ['id' => 5, 'group_id' => 1, 'name' => 'CGST Input Available (RCM)'],
            ['id' => 6, 'group_id' => 1, 'name' => 'IGST Adjustable Agnst. Advance'],
            ['id' => 7, 'group_id' => 1, 'name' => 'IGST Input Available (RCM)'],
            ['id' => 8, 'group_id' => 1, 'name' => 'IGST Refundable Agnst. Export / SEZ Unit'],
            ['id' => 9, 'group_id' => 1, 'name' => 'Cess Adjustable Agnst. Advance'],
            ['id' => 10, 'group_id' => 1, 'name' => 'Add. Cess Adjustable Agnst. Advance'],
            ['id' => 11, 'group_id' => 1, 'name' => 'Cess Input Available (RCM)'],
            ['id' => 12, 'group_id' => 18, 'name' => 'Add. Cess on GST Input'],
            ['id' => 13, 'group_id' => 18, 'name' => 'Add. Cess on GST Output'],
            ['id' => 14, 'group_id' => 18, 'name' => 'Cess on GST Input'],
            ['id' => 15, 'group_id' => 18, 'name' => 'Cess on GST Output'],
            ['id' => 16, 'group_id' => 18, 'name' => 'Cess Output (RCM)'],
            ['id' => 17, 'group_id' => 18, 'name' => 'CGST Input'],
            ['id' => 18, 'group_id' => 18, 'name' => 'CGST Output'],
            ['id' => 19, 'group_id' => 18, 'name' => 'CGST Output (RCM)'],
            ['id' => 20, 'group_id' => 18, 'name' => 'Edu. Cess on TDS'],
            ['id' => 21, 'group_id' => 18, 'name' => 'IGST Input'],
            ['id' => 22, 'group_id' => 18, 'name' => 'IGST Output'],
            ['id' => 23, 'group_id' => 18, 'name' => 'IGST Output (RCM)'],
            ['id' => 24, 'group_id' => 18, 'name' => 'SGST Input'],
            ['id' => 25, 'group_id' => 18, 'name' => 'SGST Output'],
            ['id' => 26, 'group_id' => 18, 'name' => 'SGST Output (RCM)'],
            ['id' => 27, 'group_id' => 18, 'name' => 'SHE Cess on TDS'],
            ['id' => 28, 'group_id' => 18, 'name' => 'TCS (CGST)'],
            ['id' => 29, 'group_id' => 18, 'name' => 'TCS (IGST)'],
            ['id' => 30, 'group_id' => 18, 'name' => 'TCS (SGST)'],
            ['id' => 31, 'group_id' => 18, 'name' => 'TCS (Tax Collected at Source)'],
            ['id' => 32, 'group_id' => 18, 'name' => 'TDS (CGST)'],
            ['id' => 33, 'group_id' => 18, 'name' => 'TDS (Commission or Brokerage)'],
            ['id' => 34, 'group_id' => 18, 'name' => 'TDS (Contracts to Individuals/HUF)'],
            ['id' => 35, 'group_id' => 18, 'name' => 'TDS (Contracts to Others)'],
            ['id' => 36, 'group_id' => 18, 'name' => 'TDS (Contracts to Transporter)'],
            ['id' => 37, 'group_id' => 18, 'name' => 'TDS (IGST)'],
            ['id' => 38, 'group_id' => 18, 'name' => 'TDS (Interest from a Banking Co)'],
            ['id' => 39, 'group_id' => 18, 'name' => 'TDS (Interest from a NonBanking Co)'],
            ['id' => 40, 'group_id' => 18, 'name' => 'TDS (Professionals Services)'],
            ['id' => 41, 'group_id' => 18, 'name' => 'TDS (Rent of Land)'],
            ['id' => 42, 'group_id' => 18, 'name' => 'TDS (Rent of Plant & Machinery)'],
            ['id' => 43, 'group_id' => 18, 'name' => 'TDS (Salary)'],
            ['id' => 44, 'group_id' => 18, 'name' => 'TDS (SGST)'],
            ['id' => 45, 'group_id' => 18, 'name' => 'TDS on Pymt./Purc. of Goods'],
            ['id' => 46, 'group_id' => 25, 'name' => 'Advertisement & Publicity'],
            ['id' => 47, 'group_id' => 25, 'name' => 'Bad Debts Written Off'],
            ['id' => 48, 'group_id' => 25, 'name' => 'Bank Charges'],
            ['id' => 49, 'group_id' => 25, 'name' => 'Books & Periodicals'],
            ['id' => 50, 'group_id' => 25, 'name' => 'Charity & Donations'],
            ['id' => 51, 'group_id' => 25, 'name' => 'Commission on Sales'],
            ['id' => 52, 'group_id' => 25, 'name' => 'Conveyance Expenses'],
            ['id' => 53, 'group_id' => 25, 'name' => 'Customer Entertainment Expenses'],
            ['id' => 54, 'group_id' => 25, 'name' => 'Depreciation A/c'],
            ['id' => 55, 'group_id' => 25, 'name' => 'Freight & Forwarding Charges'],
            ['id' => 56, 'group_id' => 25, 'name' => 'Legal Expenses'],
            ['id' => 57, 'group_id' => 25, 'name' => 'Miscellaneous Expenses'],
            ['id' => 58, 'group_id' => 25, 'name' => 'Office Maintenance Expenses'],
            ['id' => 59, 'group_id' => 25, 'name' => 'Office Rent'],
            ['id' => 60, 'group_id' => 25, 'name' => 'Postal Expenses'],
            ['id' => 61, 'group_id' => 25, 'name' => 'Printing & Stationery'],
            ['id' => 62, 'group_id' => 25, 'name' => 'Rounded Off'],
            ['id' => 63, 'group_id' => 25, 'name' => 'Salary'],
            ['id' => 64, 'group_id' => 25, 'name' => 'Sales Promotion Expenses'],
            ['id' => 65, 'group_id' => 25, 'name' => 'Service Charges Paid'],
            ['id' => 66, 'group_id' => 25, 'name' => 'Staff Welfare Expenses'],
            ['id' => 67, 'group_id' => 25, 'name' => 'Telephone Expenses'],
            ['id' => 68, 'group_id' => 25, 'name' => 'Travelling Expenses'],
            ['id' => 69, 'group_id' => 25, 'name' => 'Water & Electricity Expenses'],
            ['id' => 70, 'group_id' => 4, 'name' => 'Capital Equipments'],
            ['id' => 71, 'group_id' => 4, 'name' => 'Computers'],
            ['id' => 72, 'group_id' => 4, 'name' => 'Furniture & Fixture'],
            ['id' => 73, 'group_id' => 4, 'name' => 'Office Equipments'],
            ['id' => 74, 'group_id' => 4, 'name' => 'Plant & Machinery'],
            ['id' => 75, 'group_id' => 27, 'name' => 'Service Charges Receipts'],
            ['id' => 76, 'group_id' => 9, 'name' => 'Profit & Loss'],
            ['id' => 77, 'group_id' => 19, 'name' => 'Salary & Bonus Payable'],
            ['id' => 78, 'group_id' => 28, 'name' => 'Purchase'],
            ['id' => 79, 'group_id' => 29, 'name' => 'Sales'],
            ['id' => 80, 'group_id' => 14, 'name' => 'Earnest Money'],
            ['id' => 81, 'group_id' => 15, 'name' => 'Stock'],
        ];
        $accountStateId = Company::first()->state_id;
        foreach ($accounts as $account) {
            Account::create([
                'id' => $account['id'],
                'group_id' => $account['group_id'],
                'name' => $account['name'],
                'state_id' => $accountStateId,
                'is_editable' => 0,
                'is_deletable' => 0,
            ]);
        }

        Account::create([
            'id' => 82,
            'group_id' => 20,
            'name' => 'Unnathi Softech',
            'is_registered' => true,
            'op_balance' => 0,
            'cr_dr' => 'dr',
            'state_id' => $accountStateId,
            'gstin' => '29AABFU1234C1Z5',
            'is_editable' => 1,
            'is_deletable' => 1,
        ]);
        Account::create(
            [
                'id' => 83,
                'group_id' => 20,
                'name' => 'Wire Account Inc',
                'is_registered' => true,
                'op_balance' => 0,
                'cr_dr' => 'dr',
                'state_id' => $accountStateId,
                'gstin' => '29AAAAA1234C2Z6',
                'is_editable' => 1,
                'is_deletable' => 1,
            ]
        );

        $itemgroups = [
            ['id' => 1, 'name' => 'General', 'primary_id' => null, 'is_editable' => false, 'is_deletable' => false],
        ];
        foreach ($itemgroups as $itemgroup) {
            ItemGroup::create([
                'id'           => $itemgroup['id'],
                'name'         => $itemgroup['name'],
                'primary_id'   => $itemgroup['primary_id'],
                'is_editable'  => $itemgroup['is_editable'],
                'is_deletable' => $itemgroup['is_deletable'],
            ]);
        }
        $items = [
            ['id' => 1, 'group_id' => 1, 'name' => 'Test Item 001', 'has_serial_number' => false, 'uom_id' => 1, 'op_stock_qty' => rand(1, 10), 'is_physical' => true, 'tax_category_id' => 1, 'sale_price' => rand(100, 200), 'hsn_sac' => '12345678'],
            ['id' => 2, 'group_id' => 1, 'name' => 'Test Item 002', 'has_serial_number' => true, 'uom_id' => 1, 'op_stock_qty' => 1, 'is_physical' => true, 'tax_category_id' => 5, 'sale_price' => rand(100, 200), 'hsn_sac' => '12345678'],
            ['id' => 3, 'group_id' => 1, 'name' => 'Test Item 003', 'has_serial_number' => false, 'uom_id' => 1, 'op_stock_qty' => rand(1, 10), 'is_physical' => false, 'tax_category_id' => 7, 'sale_price' => rand(100, 200), 'hsn_sac' => '12345678'],
        ];
        foreach ($items as $item) {
            Item::create([
                'id' => $item['id'],
                'group_id' => $item['group_id'],
                'name' => $item['name'],
                'uom_id' => $item['uom_id'],
                'has_serial_number' => $item['has_serial_number'],
                'op_stock_qty' => $item['op_stock_qty'],
                'is_physical' => $item['is_physical'],
                'tax_category_id' => $item['tax_category_id'],
                'sale_price' => $item['sale_price'],
                'max_retail_price' => $item['sale_price'] + 50,
                'purchase_price' => $item['sale_price'] * 0.9,
                'hsn_sac' => $item['hsn_sac'],
            ]);
        }
        $additionalUOMs = [
            [
                'item_id' => 1,
                'uom_id' => 3,
                'conversion_factor' => 100
            ],
            [
                'item_id' => 1,
                'uom_id' => 4,
                'conversion_factor' => 200
            ]
        ];
        DB::table('item_uoms')->insert($additionalUOMs);

        SerialNumber::create(
            [
                'item_id' => 2,
                'serial_number' => 'OPSN001',
                'description' => 'OPSTOCK_SLNO_001',
                'is_opening_stock' => true,
                'is_returned' => false,
            ]
        );



        //PrintConfig
        $printconfigs = [
            [
                'invoice_type_id' => 3,
                'name' => 'Standard',
                'print_title' => InvoiceType::find(3)->name,
                'declaration1' => '',
                'declaration2' => '',
                'declaration3' => '',
                'declaration4' => '',
                'bank_name' => 'Karnataka Bank',
                'bank_account_number' => '2502500100588208',
                'bank_ifsc_code' => 'KARB000250',
                'bank_upi_id' => 'someupiid@kbl',
                'terms_conditions1' => '',
                'terms_conditions2' => '1. Goods once sold will not be taken back.',
                'terms_conditions3' => '2. Interest @ 18% p.a. will be charged if the payment',
                'terms_conditions4' => 'is not made with in the stipulated time.',
                'terms_conditions5' => '3. Subject to \'Koppa\' Jurisdiction only.',
                'terms_conditions6' => '',
                'signatory_information1' => 'for ' . Company::find(1)->name,
                'signatory_information2' => 'Authorised Signatory',
            ]
        ];

        foreach ($printconfigs as $printconfig) {
            InvoicePrintConfig::create([
                'invoice_type_id' => $printconfig['invoice_type_id'],
                'name' => $printconfig['name'],
                'print_title' => $printconfig['print_title'],
                'declaration1' => $printconfig['declaration1'],
                'declaration2' => $printconfig['declaration2'],
                'declaration3' => $printconfig['declaration3'],
                'declaration4' => $printconfig['declaration4'],
                'bank_name' => $printconfig['bank_name'],
                'bank_account_number' => $printconfig['bank_account_number'],
                'bank_ifsc_code' => $printconfig['bank_ifsc_code'],
                'bank_upi_id' => $printconfig['bank_upi_id'],
                'terms_conditions1' => $printconfig['terms_conditions1'],
                'terms_conditions2' => $printconfig['terms_conditions2'],
                'terms_conditions3' => $printconfig['terms_conditions3'],
                'terms_conditions4' => $printconfig['terms_conditions4'],
                'terms_conditions5' => $printconfig['terms_conditions5'],
                'terms_conditions6' => $printconfig['terms_conditions6'],
                'signatory_information1' => $printconfig['signatory_information1'],
                'signatory_information2' => $printconfig['signatory_information2']
            ]);
        }

        //Roles
        $roles = [
            ['name' => 'super_admin'],
            ['name' => 'admin'],
            ['name' => 'manager'],
            ['name' => 'staff'],
            ['name' => 'public'],
        ];
        foreach ($roles as $role) {
            Role::create($role);
        }

        //Permissions
        $permissions = [
            //accounts
            ['name' => 'account_create'],
            ['name' => 'account_edit'],
            ['name' => 'account_delete'],
            ['name' => 'account_view'],
            ['name' => 'account_any'],

            //items
            ['name' => 'item_create'],
            ['name' => 'item_edit'],
            ['name' => 'item_delete'],
            ['name' => 'item_view'],
            ['name' => 'item_any'],

            //invoice_transaction
            ['name' => 'invoice_create'],
            ['name' => 'invoice_edit'],
            ['name' => 'invoice_delete'],
            ['name' => 'invoice_view'],
            ['name' => 'invoice_any'],

            //accounting_transaction
            ['name' => 'accounting_create'],
            ['name' => 'accounting_edit'],
            ['name' => 'accounting_delete'],
            ['name' => 'accounting_view'],
            ['name' => 'accounting_any'],

        ];
        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        $role = Role::findByName('super_admin');
        $permissions = Permission::all();
        $role->syncPermissions($permissions);

        $users = User::where('is_super_admin', true)->get();
        foreach ($users as $user) {
            $user->assignRole($role);
        }
    }
}

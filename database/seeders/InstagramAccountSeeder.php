<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InstagramAccount;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class InstagramAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        InstagramAccount::create(
            [
                "username" => "ShabrinaSaury74",
                "email"    => "ShabrinaSaury74@bentsgolf.com",
                "password" => "vumoro50",
                "cookie"   => 'fbm_124024574287414=base_domain=.instagram.com; datr=8Bk8Z_imaZvwSiDKk-XDdRSi; ig_did=6141BAB1-89C2-4048-9B3E-57430316AB8A; wd=1280x585; dpr=1.5; mid=ZzwZ8AALAAGD51CgAssyqEmMZtz8; csrftoken=EjyZTf2oQgmAKsfptHEku80BIBLtgDOD; ds_user_id=70272234357; sessionid=70272234357%3AfKauSC2AkYYf35%3A11%3AAYcZ5zWWpz9SvNJP609SSo5fsSgKuf2qTNPO7Yo11A; rur="VLL\05470272234357\0541763528093:01f7c1187f1c8c4d385f89cab032d77a093a594ff9e388d50835821586d154f29cf05beb"',
                "status"   => 1,
            ]
        );
        InstagramAccount::create(
            [
                "username" => "CintyaTiara15",
                "email"    => "CintyaTiara15@bentsgolf.com",
                "password" => "racota73",
                "cookie"   => 'dpr=1.5; datr=oRo8Z5Bl-T_nJzeybQlXRtOM; ig_did=91C3830F-CE34-4559-8924-07D88C3291F3; wd=1280x585; mid=ZzwaoQALAAH1YVi5kI3gkFytaIPR; ig_nrcb=1; csrftoken=al2GxrRWhD6TLV1WAVtsFRo1pRcC2X9n; ds_user_id=70834648786; sessionid=70834648786%3ANqL1hQAFyscbHE%3A19%3AAYeBc0RpGUlIt_Nbix4NbPKV3Sa28KO-EvKQqZbAZA; ps_l=1; ps_n=1; rur="PRN\05470834648786\0541763528324:01f788aedb16d813a999516bf848914197eee22d25286f7a774fbd70690e17e4b1b944c9"',
                "status"   => 1,
            ]
        );
        InstagramAccount::create(
            [
                "username" => "KarimaYovaHidayatul23",
                "email"    => "KarimaYovaHidayatul23@bentsgolf.com",
                "password" => "zotusu84",
                "cookie"   => 'ps_l=1; ps_n=1; dpr=1.5; datr=qRs8Zwwy-zhlKgmtQ8ii3j2l; ig_did=99C1C126-2D62-4161-B832-05F1D486A7CD; wd=1280x585; mid=ZzwbqQALAAHmZmybMxs_cB4tv6CU; ig_nrcb=1; csrftoken=ck0NdxqJA5t5WqoiQjKgSvAhWOmLVTUs; ds_user_id=70807683975; sessionid=70807683975%3AeK0l3mfdDN70rt%3A21%3AAYdVCj0-XA_MzFq1TLvXdlJTRp3w_pHVarLW0GsAjA; rur="VLL\05470807683975\0541763528564:01f73fb9937b0db263482153803a532c620d1d64462ae389b12efc422a0737d7ac9d9f2c"',
                "status"   => 1,
            ]
        );
        InstagramAccount::create(
            [
                "username" => "YulianaRamsihs65",
                "email"    => "YulianaRamsihs65@bentsgolf.com",
                "password" => "jojuye15",
                "cookie"   => 'dpr=1.5; datr=GBw8Z8qLgf-cpj2ahleEAnBx; ig_did=7A1DFD00-5240-4FE4-834E-80BB9BEAD883; ps_l=1; ps_n=1; wd=1280x585; mid=ZzwcGAALAAHnOn6OrJhChC2i6DEP; ig_nrcb=1; csrftoken=0DoAKmQS91ATTMj0Lm67DqyW74WTT3pZ; ds_user_id=70215511976; sessionid=70215511976%3AwpFUzzLjBED7Oj%3A24%3AAYfnW6Ez-fSR2H6hGogVOpsVpH2b0490ITpJnSKctQ; rur="PRN\05470215511976\0541763528655:01f79b19cf2688ae84081ac11f3c91b35f54d3b2369866ab783ed46de6341c5fc4b8ca49"',
                "status"   => 1,
            ]
        );
        InstagramAccount::create(
            [
                "username" => "DellaWahyudi47",
                "email"    => "DellaWahyudi47@bentsgolf.com",
                "password" => "lulevu58",
                "cookie"   => 'dpr=1.5; datr=ZBw8Z5b7G1NnS0QZa7xlsI_2; ig_did=C64E8C5D-7110-4E15-949C-F037B1DB4F29; mid=ZzwcZAALAAEz8ztwucjmJkTL1Z0i; ig_nrcb=1; ps_l=1; ps_n=1; wd=712x584; csrftoken=OCAlXP8O2upih4fUUMoA8ZpSJ1zYXzz0; ds_user_id=70254028120; sessionid=70254028120%3Aulkfgpx7yZXOVh%3A21%3AAYfP74rtx36TOx2d9kmiWjhQeyrHHyaUtJK5PhSBaA; rur="CCO\05470254028120\0541763528769:01f7a0053e5f7acfb737510540f71d9b14e836399dc1cf3f7bae1c3469e63466a310db0b"',
                "status"   => 1,
            ]
        );
        $permission = [
            Permission::create([
                'name'        => 'read instagram account management',
                'guard_name'  => 'web',
                'description' => 'Allow to read instagram account',
            ]),
            Permission::create([
                'name'        => 'create instagram account management',
                'guard_name'  => 'web',
                'description' => 'Allow to create instagram account',
            ]),
            Permission::create([
                'name'        => 'update instagram account management',
                'guard_name'  => 'web',
                'description' => 'Allow to update instagram account',
            ]),
            Permission::create([
                'name'        => 'delete instagram account management',
                'guard_name'  => 'web',
                'description' => 'Allow to delete instagram account',
            ]),
        ];

        $role = Role::where(
            'name',
            'Super Admin'
        )->first();
        $role->givePermissionTo($permission);
    }
}

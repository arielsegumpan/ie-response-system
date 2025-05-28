<?php

namespace App\Livewire\Pages;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Organization;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;
use App\Models\Volunteer as VolunteerM;
use Woenel\Prpcmblmts\Models\PhilippineCity;
use Woenel\Prpcmblmts\Models\PhilippineRegion;
use Woenel\Prpcmblmts\Models\PhilippineBarangay;
use Woenel\Prpcmblmts\Models\PhilippineProvince;

class Volunteer extends Component
{
    public $regions;
    public $provinces = [];
    public $cities = [];
    public $barangays;



    public $selectedRegion, $selectedProvince, $selectedCity, $selectedBarangay, $selectedOrganization;
    public string $street = '';
    public string $notes = '';
    public $organizations;
    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';
    public string $phone = '';

    public $getRegionCode;
    public $getProvinceCode;
    public $getCityCode;
    public $getBarangayCode;

    protected function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:150'],
            'phone' => ['required', 'string', 'regex:/^(09|\+639)\d{9}$/'],
            'selectedRegion' => ['required', 'exists:philippine_regions,id'],
            'selectedProvince' => ['required', 'exists:philippine_provinces,id'],
            'selectedCity' => ['required', 'exists:philippine_cities,id'],
            'selectedBarangay' => ['required', 'exists:philippine_barangays,id'],
            'notes' => ['nullable', 'string', 'max:2500'],
        ];
    }

    protected function messages()
    {
        return [
            'first_name.required' => 'The first name field is required.',
            'last_name.required' => 'The last name field is required.',
            'first_name.max' => 'The first name may not be greater than 255 characters.',
            'last_name.max' => 'The last name may not be greater than 255 characters.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.max' => 'The email may not be greater than 150 characters.',
            'phone.required' => 'The phone number field is required.',
            'phone.regex' => 'The phone number must start with 09 or +639 and be 11 digits long.',
            'selectedRegion.required' => 'The region field is required.',
            'selectedProvince.required' => 'The province field is required.',
            'selectedCity.required' => 'The city field is required.',
            'selectedBarangay.required' => 'The barangay field is required.',
            'street.max' => 'The street may not be greater than 255 characters.',
            'notes.max' => 'The notes may not be greater than 2500 characters.',
        ];
    }

    public function mount()
    {
        $this->regions =  PhilippineRegion::orderBy('name')->get();
        $this->organizations = Organization::all();
    }

    public function updatedSelectedRegion($value)
    {
        $this->getRegionCode = PhilippineRegion::where('id', $value)->first();
        $this->provinces = PhilippineProvince::where('region_code', $this->getRegionCode->code)->orderBy('name')->get();
        $this->selectedProvince = null;
        $this->cities = [];
        $this->selectedCity = null;
        $this->barangays = [];
        $this->selectedBarangay = null;
    }

    public function updatedSelectedProvince($value)
    {
        $this->getProvinceCode = PhilippineProvince::where('id', $value)->first();
        $this->cities = PhilippineCity::where('province_code', $this->getProvinceCode->code)->orderBy('name')->get();
        $this->selectedCity = null;
        $this->barangays = [];
        $this->selectedBarangay = null;
    }

    public function updatedSelectedCity($value)
    {
        $this->getCityCode = PhilippineCity::where('id', $value)->first();
        $this->barangays = PhilippineBarangay::where('city_code', $this->getCityCode->code)->orderBy('name')->get();

        // $this->selectedBarangay = null;
    }

    public function submit()
    {

        $validated = $this->validate();

        $validated['first_name'] = strip_tags($validated['first_name']);
        $validated['last_name'] = strip_tags($validated['last_name']);
        $validated['email'] = filter_var($validated['email'], FILTER_SANITIZE_EMAIL);
        $validated['phone'] = preg_replace('/[^0-9+]/', '', $validated['phone']);
        $validated['notes'] = htmlspecialchars(strip_tags($validated['notes']));

        // try and catch with database transaction
        try {
            DB::beginTransaction();

            $getBrgy = PhilippineBarangay::where('id', $this->selectedBarangay)->get(['id','name'])->first();

            $full_address = Str::upper(
                ($this->street ?? '') . ', ' .
                ($getBrgy->name ?? '') . ', ' .
                ($this->getCityCode->name ?? '') . ', ' .
                ($this->getProvinceCode->name ?? '') . ', ' .
                ($this->getRegionCode->name ?? '') . ', Philippines'
            );

            // Create User
            $user = User::create([
                'name' => ucfirst($validated['first_name']) . ' ' . ucfirst($validated['last_name']),
                'email' => $validated['email'],
                'password' => bcrypt(Str::random(10)),
            ]);

            // Create Profile
            $user->profile()->create([
                'first_name' => ucfirst($validated['first_name']),
                'last_name' => ucfirst($validated['last_name']),
                'phone' => $validated['phone'],
                'region_id' => $this->selectedRegion,
                'province_id' => $this->selectedProvince,
                'city_id' => $this->selectedCity,
                'barangay_id' => $this->selectedBarangay,
                'full_address' => $full_address,
                'street' => $this->street,
            ]);
            // Create Volunteer
            VolunteerM::create([
                'user_id' => $user->id,
                'organization_id' => $this->selectedOrganization,
                'availability_status' => 'available',
                'verification_status' => 'pending',
                'notes' => $this->notes,
                'is_active' => false
            ]);

            DB::commit();

            session()->flash('success', 'Successfully applied! Please wait for approval.');
            $this->reset();
            return redirect()->route('page.volunteer');

        } catch (\Exception $e) {
            DB::rollBack();
            // Log the error
            logger()->error('Incident submission failed: ' . $e->getMessage());

            session()->flash('error', 'Something went wrong. Please try again.');
            return null;
        }

    }
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.pages.volunteer');
    }
}

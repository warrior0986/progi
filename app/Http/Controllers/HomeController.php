<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use LDAP\Result;

class HomeController extends Controller
{
    public function calculate(Request $request)
    {
        $request->validate([
            'budget' => 'required|numeric'
        ]);
        $result = [
            'budget' => 0,
            'maxAmount' => 0,
            'fees' => []
        ];

        $budget = $request->budget;
        $result['budget'] = $budget;
        $result['maxAmount'] = $budget;
        $result = $this->calculateFees($budget, $result);

        return Response::json([
            'result' => $result,
        ]);
    }

    protected function calculateFees($budget, $result)
    {
        $budget = (double) $budget;
        $fixedFees = (double) Fee::where('type', 'fixed')->sum('value');
        $associatedFees = Fee::where('type', 'assoc')->get();
        $maxAssociationFees = (double) Fee::where('type', 'assoc')->max('value');
        $minAssociationFees = (double) Fee::where('type', 'assoc')->min('value');
        $basicFee = Fee::where('name', 'basic')->first();
        $minBasicFee =  $basicFee->min;
        $maxBasicFee =  $basicFee->max;

        $minAmount = $this->tryCalculation($budget, $fixedFees, $minAssociationFees, $minBasicFee);
        $maxAmount = $this->tryCalculation($budget, $fixedFees, $maxAssociationFees, $maxBasicFee);

        $chosenBasicFee = ($minAmount < $minBasicFee) ? ($minBasicFee) : (($maxAmount > $maxBasicFee) ? $maxBasicFee : ($maxAmount*$basicFee->value));

        foreach ($associatedFees as $fee) {
            $minIsInRange = $this->isInRange($minAmount, $fee->min, $fee->max);
            $maxIsInRange = $this->isInRange($maxAmount, $fee->min, $fee->max);

            if ($minIsInRange || $maxIsInRange) {
                $chosenAssociationFee = $fee->value;
                break;
            } else {
                $chosenAssociationFee = $maxAssociationFees;
            }
        }

        $specialFee = Fee::where('name', 'special')->first();
        $chosenSpecialFee = ($budget - $fixedFees - $chosenBasicFee - $chosenAssociationFee)*($specialFee->value/100);

        $result['fees']['basic'] = $chosenBasicFee > 0 ? round($chosenBasicFee, 2) : 0;
        $result['fees']['association'] = $chosenAssociationFee > 0 ? round($chosenAssociationFee, 2) : 0;
        $result['fees']['special'] = $chosenSpecialFee > 0 ? round($chosenSpecialFee,2) : 0;
        $result['fees']['storage'] = $fixedFees > 0 ? round($fixedFees, 2) : 0;
        $result['maxAmount'] = round($budget - $result['fees']['basic'] - $result['fees']['association'] - $result['fees']['special']  - $result['fees']['storage'], 2);
        if ($result['maxAmount'] < 0) {
            $result['maxAmount'] = 0;
        }

        return $result;
    }

    protected function isInRange($amount, $min, $max)
    {
        return ($amount > $min) && ($amount < $max);
    }

    protected function tryCalculation($budget, $fixedFees, $associatedFees, $basicFees)
    {
        $result = ($budget - $fixedFees - $associatedFees - $basicFees)/1.02;
        return $result;
    }

    public function getConfig()
    {

        $feesConfig = Fee::all();

        $normalFees = $feesConfig->filter(function($fee) {
            return $fee->type !== 'assoc';
        })->map(function($fee) {
            return [
                'id' => $fee->id,
                'name' => $fee->name,
                'type' => $fee->type,
                'value' => $fee->value,
                'min' => $fee->min,
                'max' => $fee->max,
            ];
        });

        $assocFees = $feesConfig->filter(function($fee) {
            return $fee->type === 'assoc';
        })->map(function($fee) {
            return [
                'id' => $fee->id,
                'name' => $fee->name,
                'type' => $fee->type,
                'value' => $fee->value,
                'min' => $fee->min,
                'max' => $fee->max,
            ];
        });

        return Response::json([
            'normalFees' => $normalFees,
            'assocFees' => $assocFees
        ]);

    }

    public function update(Request $request) 
    {
        $fees = $request->fees['normalFees'];

        foreach ($fees as $fee) {
            $row = Fee::find($fee['id'])->update($fee);
        }

        return Response::json([], 201);
    }
}

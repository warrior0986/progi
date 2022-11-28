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
        $fees = Fee::all();

        foreach ($fees as $fee) {
             switch ($fee->type) {
                case 'fixed':
                    $result['fees'][$fee->name] = $fee->value;
                    $result['maxAmount'] = $result['maxAmount'] - $fee->value;
                    break;
                case 'percent':
                    $feeToCharge = $budget * ($fee->value/100);
                    if ($fee->min) {
                        $feeToCharge = $feeToCharge < $fee->min ? $fee->min : $feeToCharge;
                    }
                    if ($fee->max) {
                        $feeToCharge = $feeToCharge > $fee->max ? $fee->max : $feeToCharge;
                    }
                    $result['fees'][$fee->name] = $feeToCharge;
                    $result['maxAmount'] = $result['maxAmount'] - $feeToCharge;
                    break;
                case 'assoc':
                    if ($fee->max) {
                        if ($budget>= $fee->min && $budget<= $fee->max) {
                            $result['fees'][$fee->name] = $fee->value;
                            $result['maxAmount'] = $result['maxAmount'] - $fee->value;
                        }
                    } else {
                        if ($budget>= $fee->min) {
                            $result['fees'][$fee->name] = $fee->value;
                            $result['maxAmount'] = $result['maxAmount'] - $fee->value;
                        }
                    }
                    break;
                default:
                    # code...
                    break;
             }
        }

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

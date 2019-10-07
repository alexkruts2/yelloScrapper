<?php
namespace MathPHP\Tests\NumericalAnalysis\NumericalDifferentiation;

use MathPHP\NumericalAnalysis\NumericalDifferentiation\SecondDerivativeMidpointFormula;
use MathPHP\Exception;

class SecondDerivativeMidpointFormulaTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test   differentiate zero error - callback
     * @throws \Exception
     */
    public function testZeroError()
    {
        // Given f(x) = 13x² -92x + 96
        $f = function ($x) {
            return 13 * $x**2 - 92 * $x + 96;
        };

        /*
         *                                                        h²
         * Error term for the Second Derivative Midpoint Formula: - f⁽⁴⁾(ζ)
         *                                                        12
         *
         *     where ζ lies between x₀ - h and x₀ + h
         */

        // f'(x)   = 26x - 92
        // f''(x)  = 26
        // f⁽³⁾(x) = 0
        // f⁽⁴⁾(x) = 0
        // Thus, our error is zero in our formula

        // And
        $f’’ = function ($x) {
            return 26;
        };

        $n = 3;
        $a = 0;
        $b = 4;

        // Check that the midpoint formula agrees with f'(x) at x = 2
        $target   = 2;
        $expected = $f’’($target);
        // When
        $actual = SecondDerivativeMidpointFormula::differentiate($target, $f, $a, $b, $n);
        // Then
        $this->assertEquals($expected, $actual);
    }

    /**
     * @test   differentiate nonzero error - callback
     * @throws \Exception
     */
    public function testNonzeroError()
    {
        // Given f(x) = x⁴ - 13x² -92x + 96
        $f = function ($x) {
            return $x**4 - 13 * $x**2 - 92 * $x + 96;
        };

        /*
         *                                                        h²
         * Error term for the Second Derivative Midpoint Formula: - f⁽⁴⁾(ζ)
         *                                                        12
         *
         *     where ζ lies between x₀ - h and x₀ + h
         */

        // f'(x)   = 4x³ - 26x - 92
        // f''(x)  = 12x² - 26
        // f⁽³⁾(x) = 24x
        // f⁽⁴⁾(x) = 24

        // Error in Second Derivative Midpoint Formula on [0,2] (where h=1) < 2

        // And
        $f’’ = function ($x) {
            return 12 * $x**2 - 26;
        };

        $n = 3;
        $a = 0;
        $b = 2;

        // Check that the midpoint formula agrees with f'(x) at x = 1
        $target   = 1;
        $tol      = 2;
        $expected = $f’’($target);
        // When
        $actual = SecondDerivativeMidpointFormula::differentiate($target, $f, $a, $b, $n);
        // Then
        $this->assertEquals($expected, $actual, '', $tol);
    }

    /**
     * @test   differentiate zero error - array
     * @throws \Exception
     */
    public function testPointsZeroError()
    {
        // Given f(x) = 13x² -92x + 96
        $f = function ($x) {
            return 13 * $x**2 - 92 * $x + 96;
        };

        $points = [[0, $f(0)], [2, $f(2)], [4, $f(4)]];

        /*
         *                                                        h²
         * Error term for the Second Derivative Midpoint Formula: - f⁽⁴⁾(ζ)
         *                                                        12
         *
         *     where ζ lies between x₀ - h and x₀ + h
         */

        // f'(x)   = 26x - 92
        // f''(x)  = 26
        // f⁽³⁾(x) = 0
        // f⁽⁴⁾(x) = 0
        // Thus, our error is zero in our formula

        // And
        $f’’ = function ($x) {
            return 26;
        };

        // Check that the midpoint formula agrees with f'(x) at x = 2
        $target   = 2;
        $expected = $f’’($target);
        // When
        $actual = SecondDerivativeMidpointFormula::differentiate($target, $points);
        // Then
        $this->assertEquals($expected, $actual);
    }

    /**
     * @test   differentiate target exception
     * @throws \Exception
     */
    public function testTargetException()
    {
        // Given f(x) = 13x² -92x + 96
        $f = function ($x) {
            return 13 * $x**2 - 92 * $x + 96;
        };

        $points = [[0, $f(0)], [2, $f(2)], [4, $f(4)]];

        // And
        $f’’ = function ($x) {
            return 26;
        };

        $target   = 87348738473;
        $expected = $f’’($target);

        // Then
        $this->expectException(Exception\BadDataException::class);

        // When
        $actual = SecondDerivativeMidpointFormula::differentiate($target, $points);
    }
}
<?php

namespace spec\MeadSteve\PhpCurry;

use Doctrine\Instantiator\Exception\InvalidArgumentException;
use MeadSteve\PhpCurry\Curried;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CurriedSpec extends ObjectBehavior
{
    function it_wraps_a_function_with_a_single_arg()
    {
        $func = function ($hello) {return $hello;};
        $this->beConstructedWith($func);
        $this->__invoke("world")->shouldEqual("world");
    }

    function it_curries_multi_arg_functions()
    {
        $func = function ($hello, $world) {return $hello . $world;};
        $curried = new Curried($func);
        $helloFunction = $curried("hello");
        assert($helloFunction(" world") == "hello world");
    }

    function it_can_be_called_with_more_than_one_arg()
    {
        $func = function ($hello, $world) {return $hello . $world;};
        $this->beConstructedWith($func);
        $this->__invoke("hello ", "world")->shouldEqual("hello world");
    }

    function it_wont_wrap_non_callables()
    {
        $this->shouldThrow(new InvalidArgumentException);
        $this->beConstructedWith("potato");
    }
}

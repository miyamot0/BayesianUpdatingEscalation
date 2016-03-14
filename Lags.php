<?php
/*
*	Shawn Gilroy, 2015
*	Bayesian Updating applied to sequential learning tasks.
*	Extension of Sonia Goltz's work on sequence learning and escalation/persistence
*
*	CSPRNG derived from ISAAC, as shared by user Ilmari Karonen at:
*	http://stackoverflow.com/questions/14420754/isaac-cipher-in-php
*
*	Temple University; Psychology Department
*/

class Lags {

private $sequence;

/*
*	@param: $seq = sequence of wins-losses, per ISAAC PRNG (0 or 1 {Losses or Wins})
*	@return: none
*/
public function setSequence($seq = null)
{
	$this->sequence = $seq;
}

/*
*	@param: none
*	@return: returns array of warranted beliefs, per respective lag units
*/
public function getTwoLaggedPredictionSeries()
{
	$finalStr = str_replace("0","b", $this->sequence);
	$finalStr = str_replace("1","g", $finalStr);
	$finalStr = implode("", $finalStr);

	$predictions[strlen($finalStr) - 2];

	$finalCountdown = 0;
	$finalAbove = 0;
	$lastIterator = 0;

	$finalLength = strlen($finalStr);

	$preAve = 0.0;
	$extAve = 0.0;
	$counter = 0;

	$mReturner = array();

	for ($finalCountdown = 2; $finalCountdown <= $finalLength; $finalCountdown++)
	{
		$comparison[$finalCountdown + 1];
		$comparison = substr($finalStr, 0, $finalCountdown);
		$predictions[$finalCountdown - 2] = $this->nextTwoLagPredictionV($comparison, $finalCountdown);
		array_push($mReturner, $predictions[$finalCountdown - 2]);
	}

	return $mReturner;
}

/*
*	@param: none
*	@return: returns array of warranted beliefs, per respective lag units
*/
public function getThreeLaggedPredictionSeries()
{
	$finalStr = str_replace("0","b", $this->sequence);
	$finalStr = str_replace("1","g", $finalStr);
	$finalStr = implode("", $finalStr);

	$predictions[strlen($finalStr) - 3];

	$finalCountdown = 0;
	$finalAbove = 0;
	$lastIterator = 0;

	$finalLength = strlen($finalStr);

	$mReturner = array();

	for ($finalCountdown = 3; $finalCountdown <= $finalLength; $finalCountdown++)
	{
		$comparison[$finalCountdown + 1];
		$comparison = substr($finalStr, 0, $finalCountdown);
		$predictions[$finalCountdown - 3] = $this->nextThreeLagPredictionV($comparison, $finalCountdown);
		array_push($mReturner, $predictions[$finalCountdown - 3]);
	}

	return $mReturner;
}

/*
*	@param: none
*	@return: returns array of warranted beliefs, per respective lag units
*/
public function getFourLaggedPredictionSeries()
{
	$finalStr = str_replace("0","b", $this->sequence);
	$finalStr = str_replace("1","g", $finalStr);
	$finalStr = implode("", $finalStr);

	$predictions[strlen($finalStr) - 4];

	$finalCountdown = 0;
	$finalAbove = 0;
	$lastIterator = 0;

	$finalLength = strlen($finalStr);

	$mReturner = array();

	for ($finalCountdown = 4; $finalCountdown <= $finalLength; $finalCountdown++)
	{
		$comparison[$finalCountdown + 1];
		$comparison = substr($finalStr, 0, $finalCountdown);
		$predictions[$finalCountdown - 4] = $this->nextFourLagPredictionV($comparison, $finalCountdown);
		array_push($mReturner, $predictions[$finalCountdown - 4]);
	}

	return $mReturner;
}

/*
*	@param: $mGoltz = series of wins losses (0 or 1 {Losses or Wins}), $sizeOfArray = length of series
*	@return: returns array of warranted beliefs, per respective lag units
*/
public function nextTwoLagPredictionV($mGoltz = null, $sizeOfArray = null)
{
	$mString[2];

	$gg=0;
	$bb=0;
	$gb=0;
	$bg=0;

	$ggWin=0;
	$bbWin=0;
	$gbWin=0;
	$bgWin=0;

	$ggLoss=0;
	$bbLoss=0;
	$gbLoss=0;
	$bgLoss=0;

	$i=0;

	for ($i = 2; $i<$sizeOfArray; $i++)
	{
		$mString[0] = $mGoltz[$i-2];
		$mString[1] = $mGoltz[$i-1];

		if ($mString[0] == 'g' && $mString[1] == 'g')
		{
			$gg++;
				if ($mGoltz[$i] == 'g') {
					$ggWin++;
				} else if ($mGoltz[$i] == 'b') {
					$ggLoss++;
				}
		}
		else if ($mString[0] == 'b' && $mString[1] == 'b')
		{
			$bb++;
				if ($mGoltz[$i] == 'g') {
					$bbWin++;
				} else if ($mGoltz[$i] == 'b'){
					$bbLoss++;
				}
		}
		else if ($mString[0] == 'b' && $mString[1] == 'g')
		{
			$bg++;
				if ($mGoltz[$i] == 'g') {
					$bgWin++;
				} else if ($mGoltz[$i] == 'b'){
					$bgLoss++;
				}
		}
		else if ($mString[0] == 'g' && $mString[1] == 'b')
		{
			$gb++;
				if ($mGoltz[$i] == 'g') {
					$gbWin++;
				} else if ($mGoltz[$i] == 'b'){
					$gbLoss++;
				}

		}
	}

	$prediction;

	if ($mGoltz[$sizeOfArray-2] == 'g' && $mGoltz[$sizeOfArray-1] == 'g')
	{
		$prediction = (((double)$ggWin+1)/((double)$gg+2));
	}
	else if ($mGoltz[$sizeOfArray-2] == 'b' && $mGoltz[$sizeOfArray-1] == 'b')
	{
		$prediction = (((double)$bbWin+1)/((double)$bb+2));
	}
	else if ($mGoltz[$sizeOfArray-2] == 'g' && $mGoltz[$sizeOfArray-1] == 'b')
	{
		$prediction = (((double)$gbWin+1)/((double)$gb+2));
	}
	else if ($mGoltz[$sizeOfArray-2] == 'b' && $mGoltz[$sizeOfArray-1] == 'g')
	{
		$prediction = (((double)$bgWin+1)/((double)$bg+2));
	}

	return $prediction;
}

/*
*	@param: $mGoltz = series of wins losses (0 or 1 {Losses or Wins}), $sizeOfArray = length of series
*	@return: returns current warranted beliefs, per final respective lag unit
*/
public function nextThreeLagPredictionV($mGoltz = null, $sizeOfArray = null)
{
	$mString[3];

	$ggg=0;
	$ggb=0;
	$gbg=0;
	$gbb=0;
	$bgg=0;
	$bgb=0;
	$bbg=0;
	$bbb=0;

	$gggWin=0;
	$ggbWin=0;
	$gbgWin=0;
	$gbbWin=0;
	$bggWin=0;
	$bgbWin=0;
	$bbgWin=0;
	$bbbWin=0;

	$gggLoss=0;
	$ggbLoss=0;
	$gbgLoss=0;
	$gbbLoss=0;
	$bggLoss=0;
	$bgbLoss=0;
	$bbgLoss=0;
	$bbbLoss=0;

	$i=0;

	for ($i = 3; $i<$sizeOfArray; $i++) {
		$mString[0] = $mGoltz[$i-3];
		$mString[1] = $mGoltz[$i-2];
		$mString[2] = $mGoltz[$i-1];

		if ($mString[0] == 'g' && $mString[1] == 'g' && $mString[2] == 'g')
		{
			$ggg++;
				if ($mGoltz[$i] == 'g') {
					$gggWin++;
				} else if ($mGoltz[$i] == 'b') {
					$gggLoss++;
				}
		}
		else if ($mString[0] == 'g' && $mString[1] == 'b' && $mString[2] == 'g')
		{
			$gbg++;
				if ($mGoltz[$i] == 'g') {
					$gbgWin++;
				} else if ($mGoltz[$i] == 'b') {
					$gbgLoss++;
				}
		}
		else if ($mString[0] == 'g' && $mString[1] == 'g' && $mString[2] == 'b')
		{
			$ggb++;
				if ($mGoltz[$i] == 'g') {
					$ggbWin++;
				} else if ($mGoltz[$i] == 'b') {
					$ggbLoss++;
				}
		}
		else if ($mString[0] == 'g' && $mString[1] == 'b' && $mString[2] == 'b')
		{
			$gbb++;
				if ($mGoltz[$i] == 'g') {
					$gbbWin++;
				} else if ($mGoltz[$i] == 'b') {
					$gbbLoss++;
				}
		}
		else if ($mString[0] == 'b' && $mString[1] == 'g' && $mString[2] == 'g')
		{
			$bgg++;
				if ($mGoltz[$i] == 'g') {
					$bggWin++;
				} else if ($mGoltz[$i] == 'b') {
					$bggLoss++;
				}
		}
		else if ($mString[0] == 'b' && $mString[1] == 'g' && $mString[2] == 'b')
		{
			$bgb++;
				if ($mGoltz[$i] == 'g') {
					$bgbWin++;
				} else if ($mGoltz[$i] == 'b') {
					$bgbLoss++;
				}
		}
		else if ($mString[0] == 'b' && $mString[1] == 'b' && $mString[2] == 'g')
		{
			$bbg++;
				if ($mGoltz[$i] == 'g') {
					$bbgWin++;
				} else if ($mGoltz[$i] == 'b') {
					$bbgLoss++;
				}
		}
		else if ($mString[0] == 'b' && $mString[1] == 'b' && $mString[2] == 'b')
		{
			$bbb++;
				if ($mGoltz[$i] == 'g') {
					$bbbWin++;
				} else if ($mGoltz[$i] == 'b') {
					$bbbLoss++;
				}
		}
	}

		$prediction = 0;

		if ($mGoltz[$sizeOfArray-3] == 'g' && $mGoltz[$sizeOfArray-2] == 'g' && $mGoltz[$sizeOfArray-1] == 'g')
		{
			$prediction = (((double)$gggWin+1)/((double)$ggg+2));
		}
		else if ($mGoltz[$sizeOfArray-3] == 'g' && $mGoltz[$sizeOfArray-2] == 'g' && $mGoltz[$sizeOfArray-1] == 'b')
		{
			$prediction = (((double)$ggbWin+1)/((double)$ggb+2));
		}
		else if ($mGoltz[$sizeOfArray-3] == 'g' && $mGoltz[$sizeOfArray-2] == 'b' && $mGoltz[$sizeOfArray-1] == 'g')
		{
			$prediction = (((double)$gbgWin+1)/((double)$gbg+2));
		}
		else if ($mGoltz[$sizeOfArray-3] == 'g' && $mGoltz[$sizeOfArray-2] == 'b' && $mGoltz[$sizeOfArray-1] == 'b')
		{
			$prediction = (((double)$gbbWin+1)/((double)$gbb+2));
		}
		else if ($mGoltz[$sizeOfArray-3] == 'b' && $mGoltz[$sizeOfArray-2] == 'g' && $mGoltz[$sizeOfArray-1] == 'g')
		{
			$prediction = (((double)$bggWin+1)/((double)$bgg+2));
		}
		else if ($mGoltz[$sizeOfArray-3] == 'b' && $mGoltz[$sizeOfArray-2] == 'g' && $mGoltz[$sizeOfArray-1] == 'b')
		{
			$prediction = (((double)$bgbWin+1)/((double)$bgb+2));
		}
		else if ($mGoltz[$sizeOfArray-3] == 'b' && $mGoltz[$sizeOfArray-2] == 'b' && $mGoltz[$sizeOfArray-1] == 'g')
		{
			$prediction = (((double)$bbgWin+1)/((double)$bbg+2));
		}
		else if ($mGoltz[$sizeOfArray-3] == 'b' && $mGoltz[$sizeOfArray-2] == 'b' && $mGoltz[$sizeOfArray-1] == 'b')
		{
			$prediction = (((double)$bbbWin+1)/((double)$bbb+2));
		}

		return $prediction;
}

/*
*	@param: $mGoltz = series of wins losses (0 or 1 {Losses or Wins}), $sizeOfArray = length of series
*	@return: returns current warranted beliefs, per final respective lag unit
*/
public function nextFourLagPredictionV($mGoltz = null, $sizeOfArray = null)
{
	$mString[4];

	$bbbb = 0;
	$bbbg = 0;
	$bbgb = 0;
	$bbgg = 0;
	$bgbb = 0;
	$bgbg = 0;
	$bggb = 0;
	$bggg = 0;
	$gbbb = 0;
	$gbbg = 0;
	$gbgb = 0;
	$gbgg = 0;
	$ggbb = 0;
	$ggbg = 0;
	$gggb = 0;
	$gggg = 0;

	$bbbbWin = 0;
	$bbbgWin = 0;
	$bbgbWin = 0;
	$bbggWin = 0;
	$bgbbWin = 0;
	$bgbgWin = 0;
	$bggbWin = 0;
	$bgggWin = 0;
	$gbbbWin = 0;
	$gbbgWin = 0;
	$gbgbWin = 0;
	$gbggWin = 0;
	$ggbbWin = 0;
	$ggbgWin = 0;
	$gggbWin = 0;
	$ggggWin = 0;
	
	$bbbbLoss = 0;
	$bbbgLoss = 0;
	$bbgbLoss = 0;
	$bbggLoss = 0;
	$bgbbLoss = 0;
	$bgbgLoss = 0;
	$bggbLoss = 0;
	$bgggLoss = 0;
	$gbbbLoss = 0;
	$gbbgLoss = 0;
	$gbgbLoss = 0;
	$gbggLoss = 0;
	$ggbbLoss = 0;
	$ggbgLoss = 0;
	$gggbLoss = 0;
	$ggggLoss = 0;

	$i = 0;

	for ($i = 4; $i<$sizeOfArray; $i++) {
		$mString[0] = $mGoltz[$i-4];
		$mString[1] = $mGoltz[$i-3];
		$mString[2] = $mGoltz[$i-2];
		$mString[3] = $mGoltz[$i-1];

		if ($mString[0] == 'b' && $mString[1] == 'b' && $mString[2] == 'b' && $mString[3] == 'b') {
			$bbbb++;
			if ($mGoltz[$i] == 'g') {
				$bbbbWin++;
			} else if ($mGoltz[$i] == 'b') {
				$bbbbLoss++;
			}
		} else if ($mString[0] == 'b' && $mString[1] == 'b' && $mString[2] == 'b' && $mString[3] == 'g') {
			$bbbg++;
			if ($mGoltz[$i] == 'g') {
				$bbbgWin++;
			} else if ($mGoltz[$i] == 'b') {
				$bbbgLoss++;
			}
		} else if ($mString[0] == 'b' && $mString[1] == 'b' && $mString[2] == 'g' && $mString[3] == 'b') {
			$bbgb++;
			if ($mGoltz[$i] == 'g') {
				$bbgbWin++;
			} else if ($mGoltz[$i] == 'b') {
				$bbgbLoss++;
			}
		} else if ($mString[0] == 'b' && $mString[1] == 'b' && $mString[2] == 'g' && $mString[3] == 'g') {
			$bbgg++;
			if ($mGoltz[$i] == 'g') {
				$bbggWin++;
			} else if ($mGoltz[$i] == 'b') {
				$bbggLoss++;
			}
		} else if ($mString[0] == 'b' && $mString[1] == 'g' && $mString[2] == 'b' && $mString[3] == 'b') {
			$bgbb++;
			if ($mGoltz[$i] == 'g') {
				$bgbbWin++;
			} else if ($mGoltz[$i] == 'b') {
				$bgbbLoss++;
			}
		} else if ($mString[0] == 'b' && $mString[1] == 'g' && $mString[2] == 'b' && $mString[3] == 'g') {
			$bgbg++;
			if ($mGoltz[$i] == 'g') {
				$bgbgWin++;
			} else if ($mGoltz[$i] == 'b') {
				$bgbgLoss++;
			}
		} else if ($mString[0] == 'b' && $mString[1] == 'g' && $mString[2] == 'g' && $mString[3] == 'b') {
			$bggb++;
			if ($mGoltz[$i] == 'g') {
				$bggbWin++;
			} else if ($mGoltz[$i] == 'b') {
				$bggbLoss++;
			}
		} else if ($mString[0] == 'b' && $mString[1] == 'g' && $mString[2] == 'g' && $mString[3] == 'g') {
			$bggg++;
			if ($mGoltz[$i] == 'g') {
				$bgggWin++;
			} else if ($mGoltz[$i] == 'b') {
				$bgggLoss++;
			}
		} else if ($mString[0] == 'g' && $mString[1] == 'b' && $mString[2] == 'b' && $mString[3] == 'b') {
			$gbbb++;
			if ($mGoltz[$i] == 'g') {
				$gbbbWin++;
			} else if ($mGoltz[$i] == 'b') {
				$gbbbLoss++;
			}
		} else if ($mString[0] == 'g' && $mString[1] == 'b' && $mString[2] == 'b' && $mString[3] == 'g') {
			$gbbg++;
			if ($mGoltz[$i] == 'g') {
				$gbbgWin++;
			} else if ($mGoltz[$i] == 'b') {
				$gbbgLoss++;
			}
		} else if ($mString[0] == 'g' && $mString[1] == 'b' && $mString[2] == 'g' && $mString[3] == 'b') {
			$gbgb++;
			if ($mGoltz[$i] == 'g') {
				$gbgbWin++;
			} else if ($mGoltz[$i] == 'b') {
				$gbgbLoss++;
			}
		} else if ($mString[0] == 'g' && $mString[1] == 'b' && $mString[2] == 'g' && $mString[3] == 'g') {
			$gbgg++;
			if ($mGoltz[$i] == 'g') {
				$gbggWin++;
			} else if ($mGoltz[$i] == 'b') {
				$gbggLoss++;
			} //		"gggg,"
		} else if ($mString[0] == 'g' && $mString[1] == 'g' && $mString[2] == 'b' && $mString[3] == 'b') {
			$ggbb++;
			if ($mGoltz[$i] == 'g') {
				$ggbbWin++;
			} else if ($mGoltz[$i] == 'b') {
				$ggbbLoss++;
			}
		} else if ($mString[0] == 'g' && $mString[1] == 'g' && $mString[2] == 'b' && $mString[3] == 'g') {
			$ggbg++;
			if ($mGoltz[$i] == 'g') {
				$ggbgWin++;
			} else if ($mGoltz[$i] == 'b') {
				$ggbgLoss++;
			}
		} else if ($mString[0] == 'g' && $mString[1] == 'g' && $mString[2] == 'g' && $mString[3] == 'b') {
			$gggb++;
			if ($mGoltz[$i] == 'g') {
				$gggbWin++;
			} else if ($mGoltz[$i] == 'b') {
				$gggbLoss++;
			}
		} else if ($mString[0] == 'g' && $mString[1] == 'g' && $mString[2] == 'g' && $mString[3] == 'g') {
			$gggg++;
			if ($mGoltz[$i] == 'g') {
				$ggggWin++;
			} else if ($mGoltz[$i] == 'b') {
				$ggggLoss++;
			}
		}
	}

	$prediction;

	if ($mGoltz[$sizeOfArray-4] == 'g' && $mGoltz[$sizeOfArray-3] == 'g' && $mGoltz[$sizeOfArray-2] == 'g' && $mGoltz[$sizeOfArray-1] == 'g')
	{
		$prediction = (((double)$ggggWin+1)/((double)$gggg+2));
	}
	else if ($mGoltz[$sizeOfArray-4] == 'g' && $mGoltz[$sizeOfArray-3] == 'g' && $mGoltz[$sizeOfArray-2] == 'g' && $mGoltz[$sizeOfArray-1] == 'b')
	{
		$prediction = (((double)$gggbWin+1)/((double)$gggb+2));
	}
	else if ($mGoltz[$sizeOfArray-4] == 'g' && $mGoltz[$sizeOfArray-3] == 'g' && $mGoltz[$sizeOfArray-2] == 'b' && $mGoltz[$sizeOfArray-1] == 'g')
	{
		$prediction = (((double)$ggbgWin+1)/((double)$ggbg+2));
	}
	else if ($mGoltz[$sizeOfArray-4] == 'g' && $mGoltz[$sizeOfArray-3] == 'g' && $mGoltz[$sizeOfArray-2] == 'b' && $mGoltz[$sizeOfArray-1] == 'b')
	{
		$prediction = (((double)$ggbbWin+1)/((double)$ggbb+2));
	}
	else if ($mGoltz[$sizeOfArray-4] == 'g' && $mGoltz[$sizeOfArray-3] == 'b' && $mGoltz[$sizeOfArray-2] == 'g' && $mGoltz[$sizeOfArray-1] == 'g')
	{
		$prediction = (((double)$gbggWin+1)/((double)$gbgg+2));
	}
	else if ($mGoltz[$sizeOfArray-4] == 'g' && $mGoltz[$sizeOfArray-3] == 'b' && $mGoltz[$sizeOfArray-2] == 'g' && $mGoltz[$sizeOfArray-1] == 'b')
	{
		$prediction = (((double)$gbgbWin+1)/((double)$gbgb+2));
	}
	else if ($mGoltz[$sizeOfArray-4] == 'g' && $mGoltz[$sizeOfArray-3] == 'b' && $mGoltz[$sizeOfArray-2] == 'b' && $mGoltz[$sizeOfArray-1] == 'g')
	{
		$prediction = (((double)$gbbgWin+1)/((double)$gbbg+2));
	}
	else if ($mGoltz[$sizeOfArray-4] == 'g' && $mGoltz[$sizeOfArray-3] == 'b' && $mGoltz[$sizeOfArray-2] == 'b' && $mGoltz[$sizeOfArray-1] == 'b')
	{
		$prediction = (((double)$gbbbWin+1)/((double)$gbbb+2));
	}
	else if ($mGoltz[$sizeOfArray-4] == 'b' && $mGoltz[$sizeOfArray-3] == 'g' && $mGoltz[$sizeOfArray-2] == 'g' && $mGoltz[$sizeOfArray-1] == 'g')
	{
		$prediction = (((double)$bgggWin+1)/((double)$bggg+2));
	}
	else if ($mGoltz[$sizeOfArray-4] == 'b' && $mGoltz[$sizeOfArray-3] == 'g' && $mGoltz[$sizeOfArray-2] == 'g' && $mGoltz[$sizeOfArray-1] == 'b')
	{
		$prediction = (((double)$bggbWin+1)/((double)$bggb+2));
	}
	else if ($mGoltz[$sizeOfArray-4] == 'b' && $mGoltz[$sizeOfArray-3] == 'g' && $mGoltz[$sizeOfArray-2] == 'b' && $mGoltz[$sizeOfArray-1] == 'g')
	{
		$prediction = (((double)$bgbgWin+1)/((double)$bgbg+2));
	}
	else if ($mGoltz[$sizeOfArray-4] == 'b' && $mGoltz[$sizeOfArray-3] == 'g' && $mGoltz[$sizeOfArray-2] == 'b' && $mGoltz[$sizeOfArray-1] == 'b')
	{
		$prediction = (((double)$bgbbWin+1)/((double)$bgbb+2));
	}
	else if ($mGoltz[$sizeOfArray-4] == 'b' && $mGoltz[$sizeOfArray-3] == 'b' && $mGoltz[$sizeOfArray-2] == 'g' && $mGoltz[$sizeOfArray-1] == 'g')
	{
		$prediction = (((double)$bbggWin+1)/((double)$bbgg+2));
	}
	else if ($mGoltz[$sizeOfArray-4] == 'b' && $mGoltz[$sizeOfArray-3] == 'b' && $mGoltz[$sizeOfArray-2] == 'g' && $mGoltz[$sizeOfArray-1] == 'b')
	{
		$prediction = (((double)$bbgbWin+1)/((double)$bbgb+2));
	}
	else if ($mGoltz[$sizeOfArray-4] == 'b' && $mGoltz[$sizeOfArray-3] == 'b' && $mGoltz[$sizeOfArray-2] == 'b' && $mGoltz[$sizeOfArray-1] == 'g')
	{
		$prediction = (((double)$bbbgWin+1)/((double)$bbbg+2));
	}
	else if ($mGoltz[$sizeOfArray-4] == 'b' && $mGoltz[$sizeOfArray-3] == 'b' && $mGoltz[$sizeOfArray-2] == 'b' && $mGoltz[$sizeOfArray-1] == 'b')
	{
		$prediction = (((double)$bbbbWin+1)/((double)$bbbb+2));
	}

	return $prediction;
}

/*
*	@param: $sequence = current slice within sequence, $mValues = lag counts, wins, losses
*	@return: $mValues = current counts of lags, win record, loss record
*/
public function getTwoLaggedCounts($mSequence = null)
{
	$values = array();
	$mString;

	$gg=0;
	$bb=0;
	$gb=0;
	$bg=0;
	$ggWin=0;
	$bbWin=0;
	$gbWin=0;
	$bgWin=0;
	$ggLoss=0;
	$bbLoss=0;
	$gbLoss=0;
	$bgLoss=0;

	$i=0;

	for ($i = 0; $i<sizeof($mSequence)-2; $i++)
	{
		$mString[0] = $mSequence[$i];
		$mString[1] = $mSequence[$i+1];

		if ($mString[0] == 1 && $mString[1] == 1)
		{
			$gg++;
				if ($mSequence[i+2] == 1)
				{
					$ggWin++;
				}
				else if ($mSequence[i+2] == 0)
				{
					$ggLoss++;
				}
		}
		else if ($mString[0] == 0 && $mString[1] == 0)
		{
			$bb++;
				if ($mSequence[$i+2] == 1)
				{
					$bbWin++;
				}
				else if ($mSequence[i+2] == 0)
				{
					$bLoss++;
				}
		}
		else if ($mString[0] == 0 && $mString[1] == 1)
		{
			$bg++;
				if ($mSequence[$i+2] == 1)
				{
					$bgWin++;
				}
				else if ($mSequence[$i+2] == 0)
				{
					$bgLoss++;
				}
		}
		else if ($mString[0] == 1 && $mString[1] == 0)
		{
			$gb++;
				if ($mSequence[$i+2] == 1)
				{
					$gbWin++;
				}
				else if ($mSequence[$i+2] == 0)
				{
					$gbLoss++;
				}
		}
	}

	$values[0]= $gg;
	$values[1]= $bb;
	$values[2]= $gb;
	$values[3]= $bg;
	$values[4]= $ggWin;
	$values[5]= $bbWin;
	$values[6]= $gbWin;
	$values[7]= $bgWin;
	$values[8]= $ggLoss;
	$values[9]= $bbLoss;
	$values[10]= $gbLoss;
	$values[11]= $bgLoss;

	return $values;
}

/*
*	@param: $sequence = current slice within sequence, $mValues = lag counts, wins, losses
*	@return: $mValues = current counts of lags, win record, loss record
*/
public function getThreeLaggedCounts($mSequence = null)
{
	$values = array();

	$mString;

	$ggg=0;
	$ggb=0;
	$gbg=0;
	$gbb=0;
	$bgg=0;
	$bgb=0;
	$bbg=0;
	$bbb=0;
	$gggWin=0;
	$ggbWin=0;
	$gbgWin=0;
	$gbbWin=0;
	$bggWin=0;
	$bgbWin=0;
	$bbgWin=0;
	$bbbWin=0;
	$gggLoss=0;
	$ggbLoss=0;
	$gbgLoss=0;
	$gbbLoss=0;
	$bggLoss=0;
	$bgbLoss=0;
	$bbgLoss=0;
	$bbbLoss=0;

	$i=0;

	for ($i = 0; $i<sizeof($mSequence)-3; $i++)
	{

		$mString[0] = $mSequence[$i];
		$mString[1] = $mSequence[$i+1];
		$mString[2] = $mSequence[$i+2];

		if ($mString[0] == 1 && $mString[1] == 1 && $mString[2] == 1)
		{
			$ggg++;
				if ($mSequence[$i+3] == 1)
				{
					$gggWin++;
				}
				else if ($mSequence[$i+3] == 0)
				{
					$gggLoss++;
				}
		}
		else if ($mString[0] == 1 && $mString[1] == 0 && $mString[2] == 1)
		{
			$gbg++;
				if ($mSequence[$i+3] == 1)
				{
					$gbgWin++;
				}
				else if ($mSequence[$i+3] == 0)
				{
					$gbgLoss++;
				}
		}
		else if ($mString[0] == 1 && $mString[1] == 1 && $mString[2] == 0)
		{
			$ggb++;
				if ($mSequence[$i+3] == 1)
				{
					$ggbWin++;
				}
				else if ($mSequence[$i+3] == 0)
				{
					$ggbLoss++;
				}
		}
		else if ($mString[0] == 1 && $mString[1] == 0 && $mString[2] == 0)
		{
			$gbb++;
				if ($mSequence[$i+3] == 1)
				{
					$gbbWin++;
				}
				else if ($mSequence[$i+3] == 0)
				{
					$gbbLoss++;
				}
		}
		else if ($mString[0] == 0 && $mString[1] == 1 && $mString[2] == 1)
		{
			$bgg++;
				if ($mSequence[$i+3] == 1)
				{
					$bggWin++;
				}
				else if ($mSequence[$i+3] == 0)
				{
					$bggLoss++;
				}
		}
		else if ($mString[0] == 0 && $mString[1] == 1 && $mString[2] == 0)
		{
			$bgb++;
				if ($mSequence[$i+3] == 1)
				{
					$bgbWin++;
				}
				else if ($mSequence[$i+3] == 0)
				{
					$bgbLoss++;
				}
		}
		else if ($mString[0] == 0 && $mString[1] == 0 && $mString[2] == 1)
		{
			$bbg++;
				if ($mSequence[$i+3] == 1)
				{
					$bbgWin++;
				}
				else if ($mSequence[$i+3] == 0)
				{
					$bbgLoss++;
				}
		}
		else if ($mString[0] == 0 && $mString[1] == 0 && $mString[2] == 0)
		{
			$bbb++;
				if ($mSequence[$i+3] == 1)
				{
					$bbbWin++;
				}
				else if ($mSequence[$i+3] == 0)
				{
					$bbbLoss++;
				}
		}
	}

	$values[0]= $ggg;
	$values[1]= $ggb;
	$values[2]= $gbg;
	$values[3]= $gbb;
	$values[4]= $bgg;
	$values[5]= $bgb;
	$values[6]= $bbg;
	$values[7]= $bbb;

	$values[8]= $gggWin;
	$values[9]= $ggbWin;
	$values[10]= $gbgWin;
	$values[11]= $gbbWin;
	$values[12]= $bggWin;
	$values[13]= $bgbWin;
	$values[14]= $bbgWin;
	$values[15]= $bbbWin;

	$values[16]= $gggLoss;
	$values[17]= $ggbLoss;
	$values[18]= $gbgLoss;
	$values[19]= $gbbLoss;
	$values[20]= $bggLoss;
	$values[21]= $bgbLoss;
	$values[22]= $bbgLoss;
	$values[23]= $bbbLoss;

	return $values;
}

/*
*	@param: $sequence = current slice within sequence, $mValues = lag counts, wins, losses
*	@return: $mValues = current counts of lags, win record, loss record
*/
public function getFourLaggedCounts($mSequence = null)
{
	$mValues=array();

	$mString;

	$bbbb = 0;
	$bbbg = 0;
	$bbgb = 0;
	$bbgg = 0;
	$bgbb = 0;
	$bgbg = 0;
	$bggb = 0;
	$bggg = 0;
	$gbbb = 0;
	$gbbg = 0;
	$gbgb = 0;
	$gbgg = 0;
	$ggbb = 0;
	$ggbg = 0;
	$gggb = 0;
	$gggg = 0;

	$bbbbWin = 0;
	$bbbgWin = 0;
	$bbgbWin = 0;
	$bbggWin = 0;
	$bgbbWin = 0;
	$bgbgWin = 0;
	$bggbWin = 0;
	$bgggWin = 0;
	$gbbbWin = 0;
	$gbbgWin = 0;
	$gbgbWin = 0;
	$gbggWin = 0;
	$ggbbWin = 0;
	$ggbgWin = 0;
	$gggbWin = 0;
	$ggggWin = 0;

	$bbbbLoss = 0;
	$bbbgLoss = 0;
	$bbgbLoss = 0;
	$bbggLoss = 0;
	$bgbbLoss = 0;
	$bgbgLoss = 0;
	$bggbLoss = 0;
	$bgggLoss = 0;
	$gbbbLoss = 0;
	$gbbgLoss = 0;
	$gbgbLoss = 0;
	$gbggLoss = 0;
	$ggbbLoss = 0;
	$ggbgLoss = 0;
	$gggbLoss = 0;
	$ggggLoss = 0;

	$i = 0;

	for ($i = 0; $i<sizeof($mSequence)-4; $i++)
	{
		$mString[0] = $mSequence[$i];
		$mString[1] = $mSequence[$i + 1];
		$mString[2] = $mSequence[$i + 2];
		$mString[3] = $mSequence[$i + 3];

		if ($mString[0] == 0 && $mString[1] == 0 && $mString[2] == 0 && $mString[3] == 0)
		{
			$bbbb++;
			if ($mSequence[$i + 4] == 1)
			{
				$bbbbWin++;
			}
			else if ($mSequence[$i + 4] == 0)
			{
				$bbbbLoss++;
			}
		}
		else if ($mString[0] == 0 && $mString[1] == 0 && $mString[2] == 0 && $mString[3] == 1)
		{
			$bbbg++;
			if ($mSequence[$i + 4] == 1)
			{
				$bbbgWin++;
			}
			else if ($mSequence[$i + 4] == 0)
			{
				$bbbgLoss++;
			}
		}
		else if ($mString[0] == 0 && $mString[1] == 0 && $mString[2] == 1 && $mString[3] == 0)
		{
			$bbgb++;
			if ($mSequence[$i + 4] == 1)
			{
				$bbgbWin++;
			}
			else if ($mSequence[$i + 4] == 0)
			{
				$bbgbLoss++;
			}
		}
		else if ($mString[0] == 0 && $mString[1] == 0 && $mString[2] == 1 && $mString[3] == 1)
		{
			$bbgg++;
			if ($mSequence[$i + 4] == 1)
			{
				$bbggWin++;
			}
			else if ($mSequence[$i + 4] == 0)
			{
				$bbggLoss++;
			}
		}
		else if ($mString[0] == 0 && $mString[1] == 1 && $mString[2] == 0 && $mString[3] == 0)
		{
			$bgbb++;
			if ($mSequence[$i + 4] == 1)
			{
				$bgbbWin++;
			}
			else if ($mSequence[$i + 4] == 0)
			{
				$bgbbLoss++;
			}
		}
		else if ($mString[0] == 0 && $mString[1] == 1 && $mString[2] == 0 && $mString[3] == 1)
		{
			$bgbg++;
			if ($mSequence[$i + 4] == 1)
			{
				$bgbgWin++;
			}
			else if ($mSequence[$i + 4] == 0)
			{
				$bgbgLoss++;
			}
		}
		else if ($mString[0] == 0 && $mString[1] == 1 && $mString[2] == 1 && $mString[3] == 0)
		{
			$bggb++;
			if ($mSequence[$i + 4] == 1)
			{
				$bggbWin++;
			}
			else if ($mSequence[$i + 4] == 0)
			{
				$bggbLoss++;
			}
		}
		else if ($mString[0] == 0 && $mString[1] == 1 && $mString[2] == 1 && $mString[3] == 1)
		{
			$bggg++;
			if ($mSequence[$i + 4] == 1)
			{
				$bgggWin++;
			}
			else if ($mSequence[$i + 4] == 0)
			{
				$bgggLoss++;
			}
		}
		else if ($mString[0] == 1 && $mString[1] == 0 && $mString[2] == 0 && $mString[3] == 0)
		{
			$gbbb++;
			if ($mSequence[$i + 4] == 1)
			{
				$gbbbWin++;
			}
			else if ($mSequence[$i + 4] == 0)
			{
				$gbbbLoss++;
			}
		}
		else if ($mString[0] == 1 && $mString[1] == 0 && $mString[2] == 0 && $mString[3] == 1)
		{
			$gbbg++;
			if ($mSequence[$i + 4] == 1)
			{
				$gbbgWin++;
			}
			else if ($mSequence[$i + 4] == 0)
			{
				$gbbgLoss++;
			}
		} else if ($mString[0] == 1 && $mString[1] == 0 && $mString[2] == 1 && $mString[3] == 0)
		{
			$gbgb++;
			if ($mSequence[$i + 4] == 1)
			{
				$gbgbWin++;
			}
			else if ($mSequence[$i + 4] == 0)
			{
				$gbgbLoss++;
			}
		}
		else if ($mString[0] == 1 && $mString[1] == 0 && $mString[2] == 1 && $mString[3] == 1)
		{
			$gbgg++;
			if ($mSequence[$i + 4] == 1)
			{
				$gbggWin++;
			}
			else if ($mSequence[$i + 4] == 0)
			{
				$gbggLoss++;
			}
		}
		else if ($mString[0] == 1 && $mString[1] == 1 && $mString[2] == 0 && $mString[3] == 0)
		{
			$ggbb++;
			if ($mSequence[$i + 4] == 1)
			{
				$ggbbWin++;
			}
			else if ($mSequence[$i + 4] == 0)
			{
				$ggbbLoss++;
			}
		}
		else if ($mString[0] == 1 && $mString[1] == 1 && $mString[2] == 0 && $mString[3] == 1)
		{
			$ggbg++;
			if ($mSequence[$i + 4] == 1)
			{
				$ggbgWin++;
			}
			else if ($mSequence[$i + 4] == 0)
			{
				$ggbgLoss++;
			}
		}
		else if ($mString[0] == 1 && $mString[1] == 1 && $mString[2] == 1 && $mString[3] == 0)
		{
			$gggb++;
			if ($mSequence[$i + 4] == 1)
			{
				$gggbWin++;
			}
			else if ($mSequence[$i + 4] == 0)
			{
				$gggbLoss++;
			}
		}
		else if ($mString[0] == 1 && $mString[1] == 1 && $mString[2] == 1 && $mString[3] == 1)
		{
			$gggg++;
			if ($mSequence[$i + 4] == 1)
			{
				$ggggWin++;
			}
			else if ($mSequence[$i + 4] == 0)
			{
				$ggggLoss++;
			}
		}
	}

	$mValues[0] = $bbbb;
	$mValues[1] = $bbbg;
	$mValues[2] = $bbgb;
	$mValues[3] = $bbgg;
	$mValues[4] = $bgbb;
	$mValues[5] = $bgbg;
	$mValues[6] = $bggb;
	$mValues[7] = $bggg;
	$mValues[8] = $gbbb;
	$mValues[9] = $gbbg;
	$mValues[10] = $gbgb;
	$mValues[11] = $gbgg;
	$mValues[12] = $ggbb;
	$mValues[13] = $ggbg;
	$mValues[14] = $gggb;
	$mValues[15] = $gggg;

	$mValues[16] = $bbbbWin;
	$mValues[17] = $bbbgWin;
	$mValues[18] = $bbgbWin;
	$mValues[19] = $bbggWin;
	$mValues[20] = $bgbbWin;
	$mValues[21] = $bgbgWin;
	$mValues[22] = $bggbWin;
	$mValues[23] = $bgggWin;
	$mValues[24] = $gbbbWin;
	$mValues[25] = $gbbgWin;
	$mValues[26] = $gbgbWin;
	$mValues[27] = $gbggWin;
	$mValues[28] = $ggbbWin;
	$mValues[29] = $ggbgWin;
	$mValues[30] = $gggbWin;
	$mValues[31] = $ggggWin;

	$mValues[32] = $bbbbLoss;
	$mValues[33] = $bbbgLoss;
	$mValues[34] = $bbgbLoss;
	$mValues[35] = $bbggLoss;
	$mValues[36] = $bgbbLoss;
	$mValues[37] = $bgbgLoss;
	$mValues[38] = $bggbLoss;
	$mValues[39] = $bgggLoss;
	$mValues[40] = $gbbbLoss;
	$mValues[41] = $gbbgLoss;
	$mValues[42] = $gbgbLoss;
	$mValues[43] = $gbggLoss;
	$mValues[44] = $ggbbLoss;
	$mValues[45] = $ggbgLoss;
	$mValues[46] = $gggbLoss;
	$mValues[47] = $ggggLoss;

	return $mValues;
}

}

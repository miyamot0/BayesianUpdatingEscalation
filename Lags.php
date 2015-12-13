<?php
/*
*	Shawn Gilroy, 2015
*	Bayesian Updating applied to sequential learning tasks.
*	Extension of Sonia Goltz's work on sequence learning and escalation/persistence
*
*	Temple University; Psychology Department
*/

class Lags {
	private $sequence;

	private $twoLagCounts;
	private $threeLagCounts;
	private $fourLagCounts;

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
	 *	@return: $predictions = array of warranted probabilities, given the complete string sequence
	*/
	public function getTwoLaggedPredictions() 
	{
		$countdown = 0;
		$predictions = array();

		for ($countdown = 2; $countdown <= sizeof($this->sequence); $countdown++) 
		{
			$comparison = array_slice($this->sequence, 0, $countdown);
			$mValues = $this->getTwoLaggedCounts($comparison);
			$predictions[$countdown - 2] = $this->nextPredictionTwoLagged($comparison, $mValues);
		}

		return $predictions;
	}

	/*
	 *	@param: none
	 *	@return: $predictions = array of warranted probabilities, given the complete string sequence
	*/
	public function getThreeLaggedPredictions()
	{
		$countdown = 0;
		$predictions = array();

		for ($countdown = 3; $countdown <= sizeof($this->sequence); $countdown++) 
		{
			$comparison = array_slice($this->sequence, 0, $countdown);
			$mValues = $this->getThreeLaggedCounts($comparison);
			$predictions[$countdown - 3] = $this->nextPredictionThreeLagged($comparison, $mValues);
		}

		return $predictions;
	}

	/*
	 *	@param: none
	 *	@return: $predictions = array of warranted probabilities, given the complete string sequence
	*/
	public function getFourLaggedPredictions()
	{
		$countdown = 0;
		$predictions = array();

		for ($countdown = 4; $countdown <= sizeof($this->sequence); $countdown++) 
		{
			$comparison = array_slice($this->sequence, 0, $countdown);
			$mValues = $this->getFourLaggedCounts($comparison);
			$predictions[$countdown - 4] = $this->nextPredictionFourLagged($comparison, $mValues);
		}

		return $predictions;
	}

	/*
	 *	@param: $sequence = current slice within sequence, $mValues = lag counts, wins, losses
	 *	@return: $mValues = current counts of lags, win record, loss record
	*/
	public function getTwoLaggedCounts($mSequence) 
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
	public function getThreeLaggedCounts($mSequence)
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
	public function getFourLaggedCounts($mSequence) 
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

	/*
	 *	@param: $sequence = current slice within sequence, $mValues = lag counts, wins, losses
	 *	@return: $returnVal = next warranted probability, with respective to lag type
	*/
	private function nextPredictionTwoLagged($sequence, $mValues) 
	{
		$sequenceSize = sizeof($sequence);
		$returnVal = 0;

		if ($sequence[$sequenceSize-2] == 1 && $sequence[$sequenceSize-1] == 1)
		{
			$returnVal = $this->warrantedProbability($mValues[0], $mValues[4]);
		}
		else if ($sequence[$sequenceSize-2] == 0 && $sequence[$sequenceSize-1] == 0)
		{
			$returnVal = $this->warrantedProbability($mValues[1], $mValues[5]);
		}
		else if ($sequence[$sequenceSize-2] == 0 && $sequence[$sequenceSize-1] == 1)
		{
			$returnVal = $this->warrantedProbability($mValues[2], $mValues[6]);
		}
		else if ($sequence[$sequenceSize-2] == 1 && $sequence[$sequenceSize-1] == 0)
		{
			$returnVal = $this->warrantedProbability($mValues[3], $mValues[7]);
		}

		return $returnVal;
	}

	/*
	 *	@param: $sequence = current slice within sequence, $mValues = lag counts, wins, losses
	 *	@return: $returnVal = next warranted probability, with respective to lag type
	*/
	private function nextPredictionThreeLagged($sequence, $mValues)
	{
		$sequenceSize = sizeof($sequence);		
		$returnVal = 0;

		if ($sequence[$sequenceSize-3] == 1 && $sequence[$sequenceSize-2] == 1 && $sequence[$sequenceSize-1] == 1)
		{
			$returnVal = $this->warrantedProbability($mValues[0], $mValues[8]);
		}
		else
		if ($sequence[$sequenceSize-3] == 1 && $sequence[$sequenceSize-2] == 1 && $sequence[$sequenceSize-1] == 0)
		{
			$returnVal = $this->warrantedProbability($mValues[1], $mValues[9]);
		}
		else
		if ($sequence[$sequenceSize-3] == 1 && $sequence[$sequenceSize-2] == 0 && $sequence[$sequenceSize-1] == 1)
		{
			$returnVal = $this->warrantedProbability($mValues[2], $mValues[10]);
		}
		else
		if ($sequence[$sequenceSize-3] == 1 && $sequence[$sequenceSize-2] == 0 && $sequence[$sequenceSize-1] == 0)
		{
			$returnVal = $this->warrantedProbability($mValues[3], $mValues[11]);
		}
		else
		if ($sequence[$sequenceSize-3] == 0 && $sequence[$sequenceSize-2] == 1 && $sequence[$sequenceSize-1] == 1)
		{
			$returnVal = $this->warrantedProbability($mValues[4], $mValues[12]);
		}
		else
		if ($sequence[$sequenceSize-3] == 0 && $sequence[$sequenceSize-2] == 1 && $sequence[$sequenceSize-1] == 0)
		{
			$returnVal = $this->warrantedProbability($mValues[5], $mValues[13]);
		}
		else
		if ($sequence[$sequenceSize-3] == 0 && $sequence[$sequenceSize-2] == 0 && $sequence[$sequenceSize-1] == 1)
		{
			$returnVal = $this->warrantedProbability($mValues[6], $mValues[14]);
		}
		else
		if ($sequence[$sequenceSize-3] == 0 && $sequence[$sequenceSize-2] == 0 && $sequence[$sequenceSize-1] == 0)
		{
			$returnVal = $this->warrantedProbability($mValues[7], $mValues[15]);
		}

		return $returnVal;
	}

	/*
	 *	@param: $sequence = current slice within sequence, $mValues = lag counts, wins, losses
	 *	@return: $returnVal = next warranted probability, with respective to lag type
	*/
	private function nextPredictionFourLagged($sequence, $mValues) 
	{
		$sequenceSize = sizeof($sequence);		
		$returnVal;

		if ($sequence[$sequenceSize-4] == 0 && $sequence[$sequenceSize-3] == 0 &&$sequence[$sequenceSize-2] == 0 && $sequence[$sequenceSize-1] == 0)
		{
			$returnVal = $this->warrantedProbability($mValues[0], $mValues[16]);
		}
		else if ($sequence[$sequenceSize-4] == 0 && $sequence[$sequenceSize-3] == 0 &&$sequence[$sequenceSize-2] == 0 && $sequence[$sequenceSize-1] == 1)
		{
			$returnVal = $this->warrantedProbability($mValues[1], $mValues[17]);
		}
		else if ($sequence[$sequenceSize-4] == 0 && $sequence[$sequenceSize-3] == 0 &&$sequence[$sequenceSize-2] == 1 && $sequence[$sequenceSize-1] == 0)
		{
			$returnVal = $this->warrantedProbability($mValues[2], $mValues[18]);
		}
		else if ($sequence[$sequenceSize-4] == 0 && $sequence[$sequenceSize-3] == 0 &&$sequence[$sequenceSize-2] == 1 && $sequence[$sequenceSize-1] == 1)
		{
			$returnVal = $this->warrantedProbability($mValues[3], $mValues[19]);
		}
		else if ($sequence[$sequenceSize-4] == 0 && $sequence[$sequenceSize-3] == 1 &&$sequence[$sequenceSize-2] == 0 && $sequence[$sequenceSize-1] == 0)
		{
			$returnVal = $this->warrantedProbability($mValues[4], $mValues[20]);
		}
		else if ($sequence[$sequenceSize-4] == 0 && $sequence[$sequenceSize-3] == 1 &&$sequence[$sequenceSize-2] == 0 && $sequence[$sequenceSize-1] == 1)
		{
			$returnVal = $this->warrantedProbability($mValues[5], $mValues[21]);
		}
		else if ($sequence[$sequenceSize-4] == 0 && $sequence[$sequenceSize-3] == 1 &&$sequence[$sequenceSize-2] == 1 && $sequence[$sequenceSize-1] == 0)
		{
			$returnVal = $this->warrantedProbability($mValues[6], $mValues[22]);
		}
		else if ($sequence[$sequenceSize-4] == 0 && $sequence[$sequenceSize-3] == 1 &&$sequence[$sequenceSize-2] == 1 && $sequence[$sequenceSize-1] == 1)
		{
			$returnVal = $this->warrantedProbability($mValues[7], $mValues[23]);
		}
		else if ($sequence[$sequenceSize-4] == 1 && $sequence[$sequenceSize - 3] == 0 && $sequence[$sequenceSize - 2] == 0 && $sequence[$sequenceSize - 1] == 0)
		{
			$returnVal = $this->warrantedProbability($mValues[8], $mValues[24]);
		}
		else if ($sequence[$sequenceSize-4] == 1 && $sequence[$sequenceSize-3] == 0 &&$sequence[$sequenceSize-2] == 0 && $sequence[$sequenceSize-1] == 1)
		{
			$returnVal = $this->warrantedProbability($mValues[9], $mValues[25]);
		}
		else if ($sequence[$sequenceSize-4] == 1 && $sequence[$sequenceSize-3] == 0 &&$sequence[$sequenceSize-2] == 1 && $sequence[$sequenceSize-1] == 0)
		{
			$returnVal = $this->warrantedProbability($mValues[10], $mValues[26]);
		}
		else if ($sequence[$sequenceSize-4] == 1 && $sequence[$sequenceSize-3] == 0 &&$sequence[$sequenceSize-2] == 1 && $sequence[$sequenceSize-1] == 1)
		{
			$returnVal = $this->warrantedProbability($mValues[11], $mValues[27]);
		}
		else if ($sequence[$sequenceSize-4] == 1 && $sequence[$sequenceSize-3] == 1 &&$sequence[$sequenceSize-2] == 0 && $sequence[$sequenceSize-1] == 0)
		{
			$returnVal = $this->warrantedProbability($mValues[12], $mValues[28]);
		}
		else if ($sequence[$sequenceSize-4] == 1 && $sequence[$sequenceSize-3] == 1 &&$sequence[$sequenceSize-2] == 0 && $sequence[$sequenceSize-1] == 1)
		{
			$returnVal = $this->warrantedProbability($mValues[13], $mValues[29]);
		}
		else if ($sequence[$sequenceSize-4] == 1 && $sequence[$sequenceSize-3] == 1 &&$sequence[$sequenceSize-2] == 1 && $sequence[$sequenceSize-1] == 0)
		{
			$returnVal = $this->warrantedProbability($mValues[14], $mValues[30]);
		}
		else if ($sequence[$sequenceSize-4] == 1 && $sequence[$sequenceSize-3] == 1 &&$sequence[$sequenceSize-2] == 1 && $sequence[$sequenceSize-1] == 1)
		{
			$returnVal = $this->warrantedProbability($mValues[15], $mValues[31]);
		}

		return $returnVal;
	}

	/*
	 *	@param: $n = count of lag sequence, $s = history of gains in such situation
	 *	@return: float valuation of warranted probability/beliefs
	*/
	private function warrantedProbability($n, $s) 
	{
		return round((((double)$s+1)/((double)$n+2)),2);
	}

}

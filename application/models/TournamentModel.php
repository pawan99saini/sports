<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class TournamentModel extends CI_Model {
	public function __construct() {
		parent::__construct();

		$this->load->model('process_data');
	}

    private function createAdvancedStageMatches($tournamentID) {
        $tournament = $this->process_data->get_data('tournaments', array('id' => $tournamentID));
        $advancedStageNeeded = $tournament[0]->advancedStageNeeded;

        // Only proceed if advanced stages are needed
        if ($advancedStageNeeded > 0) {
            $currentRound = $this->getCurrentRound($tournamentID);
            $winners 	  = $this->getWinnersFromRound($tournamentID, $currentRound);

            // Create matches for the advanced stage dynamically
            $this->createMatches($tournamentID, $winners, 1, 2); // Start with round 1 and match type 2 (advanced)
        }
    }

    private function createMatches($tournamentID, $players, $round, $matchType) {
        $numPlayers = count($players);
        $groupID 	= 1;

        // Create matches for the given round
        for ($i = 0; $i < $numPlayers; $i += 2) {
            $player1 = $players[$i];
            $player2 = ($i + 1 < $numPlayers) ? $players[$i + 1] : 0; // Handle odd number of players
            $this->insertMatch($tournamentID, $groupID++, $player1, $player2, $round, $matchType);
        }
    }

    private function insertMatch($tournamentID, $groupID, $player1, $player2, $round, $matchType) {
        $match = array(
            'tournamentID' => $tournamentID,
            'groupID'      => $groupID,
            'player_1_ID'  => $player1,
            'player_2_ID'  => $player2,
            'round'        => $round,
            'matchType'    => $matchType,
            'winnerID'     => 0,
            'status'       => 1
        );

        $matchID = $this->process_data->create_data('tournament_matches', $match);

        $this->process_data->create_match_chat_group($tournamentID, $matchID, $player1, 1);
        $this->process_data->create_match_chat_group($tournamentID, $matchID, $player2, 2);
    }

    public function markWinner($matchID, $winnerID) {
        // Update the match with the winner
        $this->db->update('tournament_matches', array('winnerID' => $winnerID), array('id' => $matchID));

        // Get the match details
        $match 		  = $this->getMatchDetails($matchID);
        $tournamentID = $match->tournamentID;
        $round 		  = $match->round;
        $matchType 	  = $match->matchType;

        // Get the total number of players
        $totalPlayers = $this->getPlayerCount($tournamentID);
        $totalRounds = strlen(decbin($totalPlayers - 1));

        if ($matchType == 1 && $this->isFinalNormalRound($round, $totalRounds)) {
            // Create advanced stage matches if it's the final normal round
            $this->createAdvancedStageMatches($tournamentID);
        } else {
            // Progress the winner to the next round/match type
            $this->progressWinner($tournamentID, $round, $matchType, $match->groupID, $winnerID);
        }
    }

    private function isFinalNormalRound($currentRound, $totalRounds) {
        return $currentRound == $totalRounds - 1;
    }

    private function getPlayerCount($tournamentID) {
        return $this->db->where('tournamentID', $tournamentID)->count_all_results('tournament_players');
    }

    private function progressWinner($tournamentID, $currentRound, $currentMatchType, $currentGroupID, $winnerID) {
        $newRound = $currentRound + 1;
        $newMatchType = $currentMatchType;

        // Check for free slot in the next round
        $freeSlotMatch = $this->getFreeSlotMatch($tournamentID, $newRound, $newMatchType);
        if ($freeSlotMatch) {
            $this->assignWinnerToFreeSlot($freeSlotMatch, $winnerID);
        } else {
            // If no free slot, create a new match
            $this->createNewMatch($tournamentID, $currentGroupID, $winnerID, $newRound, $newMatchType);
        }
    }

    private function getFreeSlotMatch($tournamentID, $round, $matchType) {
        return $this->db->where('tournamentID', $tournamentID)
                        ->where('round', $round)
                        ->where('matchType', $matchType)
                        ->group_start()
                        ->where('player_1_ID', 0)
                        ->or_where('player_2_ID', 0)
                        ->group_end()
                        ->get('tournament_matches')
                        ->row();
    }

    private function assignWinnerToFreeSlot($match, $winnerID) {
        if ($match->player_1_ID == 0) {
            $this->db->update('tournament_matches', ['player_1_ID' => $winnerID], ['id' => $match->id]);
            $slot = 1;
        } else {
            $this->db->update('tournament_matches', ['player_2_ID' => $winnerID], ['id' => $match->id]);
            $slot = 2;
        }

        $this->process_data->create_match_chat_group($tournamentID, $newMatchID, $winnerID, $slot);
    }

    private function createNewMatch($tournamentID, $groupID, $winnerID, $round, $matchType) {
        $match = [
            'tournamentID' => $tournamentID,
            'groupID'      => $this->determineGroupID($groupID, $round),
            'player_1_ID'  => $winnerID,
            'player_2_ID'  => 0,
            'round'        => $round,
            'matchType'    => $matchType,
            'winnerID'     => 0,
            'status'       => 1
        ];

        $newMatchID = $this->db->insert('tournament_matches', $match);

        $this->process_data->create_match_chat_group($tournamentID, $newMatchID, $winnerID);
    }

    private function determineGroupID($currentGroupID, $round) {
        // Determine group ID logic can be customized as needed
        return $currentGroupID;
    }

    private function getCurrentRound($tournamentID) {
        return $this->db->select_max('round')->where('tournamentID', $tournamentID)->get('tournament_matches')->row()->round;
    }

    private function getWinnersFromRound($tournamentID, $round) {
    	$arrgs = array(
    		'tournamentID' => $tournamentID,
    		'round'		   => $round,
    	);

    	$getWinnersFromRoundData = $this->process_data->get_data('tournament_matches', $arrgs);

    	$winnerID = array();

    	foreach($getWinnersFromRoundData as $winnerRound):
    		$winnerID[] = $winnerRound->winnerID;
    	endforeach;

    	return $winnerID;
        // return $this->db->select('winnerID')
        //                 ->where('tournamentID', $tournamentID)
        //                 ->where('round', $round)
        //                 ->get('tournament_matches')
        //                 ->result_array();
    }

    private function getMatchDetails($matchID) {
        return $this->db->get_where('tournament_matches', ['id' => $matchID])->row();
    }

    public function isFinalRound($tournamentID, $matchID) {
    	$totalPlayers = $this->process_data->get_data('tournament_players', array('tournamentID' => $tournamentID));
		$playersCount = count($totalPlayers);
		$totalRounds  = strlen(decbin($playersCount - 1));

		$getTournamentQuery = "SELECT tournament.* FROM tournament LEFT JOIN tournament_matches ON tournament_matches.tournamentID = tournament.id WHERE tournament_matches.id = '" . $matchID . "'";

        $tournamentData   = $this->db->query($getTournamentQuery)->result();
		$getMatchDetails  = $this->process_data->get_data('tournament_matches', array('id' => $matchID));
		$player1LossCount = $this->process_data->looser_count($tournamentID, $getMatchDetails[0]->player_1_ID);
		$player2LossCount = $this->process_data->looser_count($tournamentID, $getMatchDetails[0]->player_2_ID);

		if($player1LossCount >= 2 || $player2LossCount >= 2) {
			return true;
		} else {
			return false;
		}
    }
}
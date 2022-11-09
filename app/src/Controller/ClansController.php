<?php
declare(strict_types=1);

namespace App\Controller;

use App\Logic\Config\WgApi;
use App\Logic\Helper\Speach2Lang;
use Cake\Core\Configure;
use LanguageDetector\LanguageDetector;

/**
 * Clans Controller
 *
 * @property \App\Model\Table\ClansTable $Clans
 * @method \App\Model\Entity\Clan[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ClansController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $clans = $this->paginate($this->Clans);

        $this->set(compact('clans'));
    }

    public function homepage(){

    }


 public function playersWithoutClans(){

        $lang = Configure::read("wot_lang");

        $connetion = \Cake\Datasource\ConnectionManager::get('default');
        $query = $connetion->execute('SELECT p.id as Spieler_ID, p.nickname as Nickname, date(p.quit) as Austritt, date(p.lastBattle) as LetztesGefecht,
       (SELECT  tag FROM histories INNER JOIN clans c on histories.clan_id = c.id WHERE player_id = p.id ORDER BY joined desc limit 1) as LetzerClan,
       (SELECT  GROUP_CONCAT(DISTINCT lang_id) FROM histories INNER JOIN clans c on histories.clan_id = c.id WHERE player_id = p.id  ORDER BY joined ) as Sprachen
        FROM players p
        WHERE p.clan_id is null AND p.lastBattle > curdate() - INTERVAL 30 DAY
        HAVING Sprachen LIKE ?
        ORDER BY date(p.quit) desc;',['%'.$lang."%"])->fetchAll('assoc');

        $this->set(compact('query'));
 }





    /**
     * View method
     *
     * @param string|null $id Clan id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $clan = $this->Clans->get($id, [
            'contain' => ['Histories', 'Players', "Langs"],
        ]);

        $detector = new LanguageDetector();

        $language = $detector->evaluate($clan->description)->getScores();

        $this->set("lang", $language); // Prints something like 'en'

        $this->set(compact('clan'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $clan = $this->Clans->newEmptyEntity();
        if ($this->request->is('post')) {
            $clan = $this->Clans->patchEntity($clan, $this->request->getData());
            if ($this->Clans->save($clan)) {
                $this->Flash->success(__('The clan has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The clan could not be saved. Please, try again.'));
        }
        $this->set(compact('clan'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Clan id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $clan = $this->Clans->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $clan = $this->Clans->patchEntity($clan, $this->request->getData());
            if ($this->Clans->save($clan)) {
                $this->Flash->success(__('The clan has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The clan could not be saved. Please, try again.'));
        }
        $langs = $this->Clans->Langs->find('list')->all();
        $this->set(compact('clan', "langs"));
    }

    /**
     * Delete method
     *
     * @param string|null $id Clan id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $clan = $this->Clans->get($id);
        if ($this->Clans->delete($clan)) {
            $this->Flash->success(__('The clan has been deleted.'));
        } else {
            $this->Flash->error(__('The clan could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

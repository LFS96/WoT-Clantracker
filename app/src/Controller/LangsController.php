<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Langs Controller
 *
 * @property \App\Model\Table\LangsTable $Langs
 * @method \App\Model\Entity\Lang[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LangsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $langs = $this->paginate($this->Langs);

        $this->set(compact('langs'));
    }

    /**
     * View method
     *
     * @param string|null $id Lang id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $lang = $this->Langs->get($id, [
            'contain' => ['Clans'],
        ]);

        $this->set(compact('lang'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $lang = $this->Langs->newEmptyEntity();
        if ($this->request->is('post')) {
            $lang = $this->Langs->patchEntity($lang, $this->request->getData());
            if ($this->Langs->save($lang)) {
                $this->Flash->success(__('The lang has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The lang could not be saved. Please, try again.'));
        }
        $this->set(compact('lang'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Lang id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $lang = $this->Langs->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $lang = $this->Langs->patchEntity($lang, $this->request->getData());
            if ($this->Langs->save($lang)) {
                $this->Flash->success(__('The lang has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The lang could not be saved. Please, try again.'));
        }
        $this->set(compact('lang'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Lang id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $lang = $this->Langs->get($id);
        if ($this->Langs->delete($lang)) {
            $this->Flash->success(__('The lang has been deleted.'));
        } else {
            $this->Flash->error(__('The lang could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

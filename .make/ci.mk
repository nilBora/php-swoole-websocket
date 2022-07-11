.PHONY: ci-push-all
ci-push-all: ## git push with deploying all brands (uc, mc, ic)
	git push -o ci.variable="DEPLOY_UC=1" -o ci.variable="DEPLOY_MC=1" -o ci.variable="DEPLOY_IC=1"

.PHONY: ci-push-uc
ci-push-uc: ## git push with deploying only the uc brand
	git push -o ci.variable="DEPLOY_UC=1" -o ci.variable="DEPLOY_MC=0" -o ci.variable="DEPLOY_IC=0"

.PHONY: ci-push-mc
ci-push-mc: ## git push with deploying only the mc brand
	git push -o ci.variable="DEPLOY_UC=0" -o ci.variable="DEPLOY_MC=1" -o ci.variable="DEPLOY_IC=0"

.PHONY: ci-push-ic
ci-push-ic: ## git push with deploying only the ic brand
	git push -o ci.variable="DEPLOY_UC=0" -o ci.variable="DEPLOY_MC=0" -o ci.variable="DEPLOY_IC=1"

.PHONY:ci-push-skip
ci-push-skip: ## git push without deploying any brand
	git push -o ci.skip
